<?php
    namespace App\Http\Controllers\Api\V1;

    use App\Http\Controllers\Controller;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;

    class AuthController extends Controller {
        public function register(Request $request) {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6'
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token
            ], 201);
        }

        public function login(Request $request)
        {
            $query = User::query();

            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $user = $query->where('email', $request->email)->first(); //Verificar esse "query()"

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Credenciais inválidas'
                ], 401);
            }

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user
            ]);
        }

        public function logout(Request $request)
        {
            $request->user()->tokens()->delete();

            return response()->json([
                'message' => 'Logout realizado'
            ]);
        }
    }
?>
