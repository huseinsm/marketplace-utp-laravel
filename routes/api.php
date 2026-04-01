use App\Http\Controllers\ProductController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Middleware\CheckCategoryRequest;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfilesController;

Route::middleware([CheckCategoryRequest::class])->group(function () {
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
});

Route::prefix('users')->group(function () {
    Route::post('/', [UsersController::class, 'createUsers']);
    Route::get('/', [UsersController::class, 'getUsers']);
    Route::get('/{id}', [UsersController::class, 'getUsersById']);
});

Route::prefix('profiles')->group(function () {
    Route::post('/', [ProfilesController::class, 'createProfiles']);
    Route::get('/', [ProfilesController::class, 'getProfiles']);
    Route::get('/users', [ProfilesController::class, 'getUsersWithProfiles']);
    Route::get('/{id}', [ProfilesController::class, 'getProfilesById']);
});

Route::post('/products', [ProductController::class, 'store']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
