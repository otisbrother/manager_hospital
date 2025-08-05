<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\DoctorLoginRequest;
use App\Models\Doctor;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class DoctorAuthController extends Controller
{
    // Constants cho messages
    private const ERROR_EMAIL_NOT_FOUND = 'Email này không tồn tại trong hệ thống. Vui lòng liên hệ admin để được cấp email.';
    private const ERROR_ACCOUNT_ACTIVATED = 'Tài khoản này đã được kích hoạt. Vui lòng đăng nhập.';
    private const ERROR_ACTIVATION_FAILED = 'Có lỗi xảy ra khi kích hoạt tài khoản. Vui lòng thử lại.';
    private const ERROR_SYSTEM_ERROR = 'Có lỗi hệ thống xảy ra. Vui lòng thử lại sau hoặc liên hệ admin.';
    private const SUCCESS_ACTIVATION = 'Tài khoản đã được kích hoạt thành công! Vui lòng đăng nhập.';

    /**
     * Display the doctor login view.
     */
    public function create(): View
    {
        return view('auth.doctor.login');
    }

    /**
     * Handle an incoming doctor authentication request.
     */
    public function store(DoctorLoginRequest $request): RedirectResponse
    {
        Log::info('🔐 Doctor login attempt', [
            'email' => $request->input('email'),
            'ip' => $request->ip()
        ]);

        $request->authenticate();

        $request->session()->regenerate();
        //  Auth::guard('doctor')->regenerate();

        $doctor = Auth::guard('doctor')->user();
        Log::info('✅ Doctor authenticated successfully', [
            'doctor_id' => $doctor->id,
            'doctor_name' => $doctor->name,
            'redirecting_to' => route('doctors.dashboard')
        ]);

        return redirect()->intended(route('doctors.dashboard'));
    }

    /**
     * Display the doctor registration view.
     */
    public function createRegister(): View
    {
        return view('auth.doctor.register');
    }

    /**
     * Handle an incoming doctor registration request.
     */
    public function storeRegister(Request $request): RedirectResponse
    {
        // Debug: Log khi method được gọi
        Log::info('🔥 Doctor activation attempt started', [
            'email' => $request->input('email'),
            'has_password' => !empty($request->input('password')),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        // Validate input
        $validated = $this->validateActivationRequest($request);
        
        Log::info('✅ Validation passed', $validated);
        
        try {
            return DB::transaction(function () use ($validated) {
                $doctor = $this->findDoctorForActivation($validated['email']);
                
                Log::info('🔍 Doctor found for activation', [
                    'doctor_id' => $doctor->id,
                    'current_password_exists' => !empty($doctor->password)
                ]);
                
                $this->activateDoctor($doctor, $validated['password']);
                
                $this->logSuccessfulActivation($doctor);
                
                return redirect()->route('doctor.login')
                    ->with('status', self::SUCCESS_ACTIVATION);
            });
            
        } catch (ValidationException $e) {
            Log::warning('❌ Validation failed', $e->errors());
            return back()->withErrors($e->errors())->onlyInput('email');
        } catch (\Exception $e) {
            $this->logActivationError($validated['email'], $e);
            
            return back()->withErrors([
                'email' => self::ERROR_SYSTEM_ERROR
            ])->onlyInput('email');
        }
    }

    /**
     * Validate the activation request
     */
    private function validateActivationRequest(Request $request): array
    {
        return $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);
    }

    /**
     * Find doctor for activation and validate status
     */
    private function findDoctorForActivation(string $email): Doctor
    {
        $doctor = Doctor::where('email', $email)->first();

        if (!$doctor) {
            throw ValidationException::withMessages([
                'email' => [self::ERROR_EMAIL_NOT_FOUND]
            ]);
        }

        if ($doctor->password) {
            throw ValidationException::withMessages([
                'email' => [self::ERROR_ACCOUNT_ACTIVATED]
            ]);
        }

        return $doctor;
    }

    /**
     * Activate doctor account
     */
    private function activateDoctor(Doctor $doctor, string $password): void
    {
        Log::info('🔄 Attempting to activate doctor account', [
            'doctor_id' => $doctor->id,
            'email' => $doctor->email,
            'has_existing_password' => !empty($doctor->password)
        ]);

        $updated = $doctor->update([
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);

        Log::info('📊 Database update result', [
            'doctor_id' => $doctor->id,
            'update_successful' => $updated,
            'new_password_set' => !empty($doctor->password)
        ]);

        if (!$updated) {
            Log::error('Failed to update doctor password during activation', [
                'doctor_id' => $doctor->id,
                'email' => $doctor->email
            ]);
            
            throw new \Exception('Database update failed');
        }
    }

    /**
     * Log successful activation
     */
    private function logSuccessfulActivation(Doctor $doctor): void
    {
        Log::info('Doctor account activated successfully', [
            'doctor_id' => $doctor->id,
            'email' => $doctor->email,
            'activated_at' => now()
        ]);
    }

    /**
     * Log activation error
     */
    private function logActivationError(string $email, \Exception $e): void
    {
        Log::error('Exception during doctor account activation', [
            'email' => $email,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }

    /**
     * Destroy an authenticated doctor session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('doctor')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('doctor.login');
    }
} 