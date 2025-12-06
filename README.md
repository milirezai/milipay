<h1 style="center">Monarch</h1>

<br>
<h4>Installation:<h4>
<code>
git clone https://github.com/milirezai/Monarch.git
</code>
<br>

<h4>Configuration:</h4>
The web application's name
<code>
APP_NAME=Monarch
</code>
<br>
<br>
Framework version
<code>
V_FRAMEWORK=v2.1.0
</code>
<br>
<br>
App url
<code>
APP_URL=http://localhost:8041
</code>
<br>
<br>
Supported databases
<code>
DB_CONNECTION=mysql
</code>
<br>
<br>
Address database host
<code>
DB_HOST=127.0.0.1
</code>
<br>
<br>
Port for database connection
<code>
DB_PORT=3306
</code>
<br>
<br>
App database name
<code>
DB_NAME=Monarch
</code>
<br>
<br>
Default database account name
<code>
DB_USERNAME=root
</code>
<br>
<br>
Default database account password
<code>
DB_PASSWORD=
</code>
<br>
<br>
Email is enabled by default.
<code>
PHP_MAILER=true
</code>
<br>
<br>
Host for sending emails
<code>
HOST=smtp.gmail.com
</code>
<br>
<br>
SMTPAUTH is enabled by default for sending emails.
<code>
SMTPAUTH=true
</code>
<br>
<br>
The email address you want to use to send emails.
<code>
USERNAME=monarchframework@gmail.com
</code>
<br>
<br>
Default port for sending email
<code>
PORT=587
</code>
<br>
<br>
The email address you want to use to send emails.
<code>
MAIL=monarchframework@gmail.com
</code>
<br>
<br>
Email username
<code>
NAME=Monarch
</code>
<br>
<br>
Email debugging is disabled by default.
<code>
SMTPDEBUG=0
</code>
<br>
<br>
To support Persian language for better performance
<code>
CHARSET=UTF-8
</code>
<br>
<br>
The use of HTML is enabled by default.
<code>
HTML=true
</code>

<br>
<h4>Service Providers:</h4>
Service providers are present on all pages and are loaded by default.<br>
    | The application service provider includes views and data<br>
    | which we need in more than one view.<br>
    | We define them in one place to avoid code duplication and improve application performance<br>
    | and we pass them to the views we're interested in.<br>

create a Service providers
```php
php factory make:provider AppProvider
```

```php
<?php

namespace App\Providers;

class AppServiceProvider extends Provider
{

    public function boot()
    {
        //
    }

}
```
<h5>You can define the items you need on all pages in the boot method and finally submit it..</h5>

```php
    public function boot()
    {
        $products = Product::all();
            return
                [
                    'products' => $products,
                ];
        });
    }


    foreach ($products as $product){
        dd($product)
    }
```
<h5>Sending user cart products to all pages using Composer class:</h5>
```php
    public function boot()
    {
        Composer::view(['app.index', 'app.about', 'app.service', 'app.menu', 'app.booking', 'app.contact', 'app.cart'],function (){
            $carts = allItemCart();
            return
                [
                    'carts' => $carts,
                ];
        });
    }
```
<h5>The view method takes two arguments:
The first argument is the names of the views, which are in the form of an array.
The second argument is a closure that returns an array.
</h5>


<h4>Routing:</h4>
<h5>The application routes are defined in the route directory in two files: web.php and api.php.</h5>
The router allows you to register routes that respond to any HTTP verb:

```php
// web.php
use System\Router\Http\Web\Route;

Route::get($url,[$controller,$method],$name);
Route::post($url,[$controller,$method],$name);
Route::put($url,[$controller,$method],$name);
Route::delete($url,[$controller,$method],$name);

// api.php
use System\Router\Http\Web\Route;

Route::get($url,[$controller,$method],$name);
Route::post($url,[$controller,$method],$name);

```
route:
```php

use App\Http\Controllers\HomeController;

Route::get('/',[HomeController::class,'index'],'home.index');
```
Each of these methods accepts three arguments:<br>
The first is the route url, <br>
The second, which is an array, takes the controller and method names, <br>
The third parameter, which is optional, is a name for the route that must be unique.<br>
```php

use App\Http\Controllers\UserController;

Route::get('/users/{1}',[UserController::class,'show'],'users.show');
```
Arguments can be considered for route.<br>
Controllers must be used.


<h4>Controllers:</h4>
Controllers can group related request-handling logic into a single class. For example, a UserController class might handle all user-related input requests, including displaying, creating, updating, and deleting users. By default, controllers are stored in the app/Http/Controllers directory.

create a Controller
```php
php factory make:controller UserController
```

```php
<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcom');
    }
}
```

<h4>HTTP Requests:</h4>
The System\Request\Request class provides an object-oriented way to interact with the current HTTP request handled by your application, as well as retrieve the input, cookies, and files sent with the request.

Create a request class:
```php
php factory make:request UserRequest
```


```php
<?php
namespace App\Http\Request;

use System\Request\Request;

class ExampleRequest extends Request
{
    public function rules()
    {

    }
}
```
Requests can be managed with classes that inherit from Request.<br>
Within the rules method, you can send the rules that are required on requests as one and then use them within controllers.

```php
    public function rules()
    {
        return [
            'example' => 'rules',
        ]
    }
```
Rules that can be used:<br><br>
fileValidation
<ul>
<li>required</li>
<li>mimes:</li>
<li>max</li>
<li>min</li>
</ul>
normalValidation
<ul>
<li>required</li>
<li>mimes</li>
<li>max</li>
<li>min</li>
<li>exists</li>
<li>email</li>
<li>date</li>
<li>confirmed</li>
<li>unique</li>
<li>number</li>
</ul>
Usage example

```php
    protected function rules()
    {
            return [
                'title' => 'required|max:191|min:10',
                'image' => 'file|mimes:jpeg,jpg,png,gif',
                'cat_id' => 'exist:categories,id',
                'status' => 'number',
                'email'  => 'email|unique',
                'password' => 'confirmed'
            ];
     }
```
Use in the controller

```php
class HomeController extends Controller
{
    public function store()
    {
        $request = new ExampleRequest;
    }
}

```
Applied methods:


This method can be used to understand the method being sent and define rules based on that.
```php
    public function rules()
    {
        if ($this->isMethod('put'))
        {
            return
                [
                    'first_name' => 'max:191',
                    'last_name' => 'max:191',
                    'avatar' => 'file|mimes:png,jpg,jpeg',
                    'position' => 'required|max:191'
                ];
        }
        else
        {
            return
                [
                    'first_name' => 'required|max:191',
                    'last_name' => 'required|max:191',
                    'avatar' => 'file|required|mimes:png,jpg,jpeg',
                    'position' => 'required|max:191'
                ];
        }
    }
```

This method can be used to receive all sent items.

```php
class HomeController extends Controller
{
    public function store()
    {
        $request = new ExampleRequest;
        $request->all()
    }
}
```
If a file has been sent, it can be accessed using this method.
```php
class HomeController extends Controller
{
    public function store()
    {
        $request = new ExampleRequest;
        $request->file($name)
    }
}
```
<h4>view:</h4>

```php
All views should be defined in the resources/view/  directory.
```

```php
<html>
    <body>
        <h1>Hello, {{ $name }}</h1>
    </body>
</html>

```

You may create a view by placing a file with the .blade.php extension in your application's resources/views directory. The .blade.php extension informs the framework that the file contains a Blade template. Blade templates contain HTML as well as Blade directives that allow you to easily echo values.


Views may also be nested within subdirectories of the resources/views directory. "Dot" notation may be used to reference nested views. For example, if your view is stored at resources/views/admin/profile.blade.php, you may return it from one of your application's routes / controllers like so:

```php
return view('admin.profile');
```

View composers are callbacks or class methods that are called when a view is rendered. If you have data that you want to be bound to a view each time that view is rendered, a view composer can help you organize that logic into a single location. View composers may prove particularly useful if the same view is returned by multiple routes or controllers within your application and always needs a particular piece of data.Data must be presented in the form of a presentation.

```php
<?php

namespace App\Providers;

class AppServiceProvider extends Provider
{

    public function boot()
    {
        Composer::view(['app.index','app.about'],function (){
            $menus = Menu::all();
            return [
                'menus' => $menus
            ]
        });
    }
    
}
```

To render views, you can use the view() helper function.

```php
return view('admin.profile');
```

This function takes in arguments:
The first is the name of the view
The second is the data we want to use in the view sent.

```php
$users = User::all();

return view('admin.users',compact('users'));
```

To identify addresses, you should act like the example below.

```php
// /resources/view/app/index
return view('app.index');
```


Blade's @include directive allows you to include a Blade view from within another view. All variables that are available to the parent view will be made available to the included view:

```php
<div>
// /resources/view/app/index
    @include('app.component')
 
    <form>
        <!-- Form Contents -->
    </form>
</div>
```

Basically yield('content') is a marker. For example, in the tag if you put a yield('content'), your saying this section has the name of content and by the way, you can name inside of the pranthesis anything you want. it doesn't have to be content. it can be yield('inside'). or anything you want.

And then in the child page where you want to import html from your layout page, you just say section('name of the section'). for example, if you have marked your header in your layout page as yield('my_head_band') <-- or anything else you want, then in your child page you just say @section('my_head_band').


```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        // <title>may app</title>
    @yield('title')
</head>
<body>
    @yield('script')
</body>
</html>
```
```php
@section('title') 
        <title>may app</title>
@endsection



@section('script') 
     <script src="<?= asset('app.js') ?>"></script>
@endsection

```
When defining a child view, use the @extends Blade directive to specify which layout the child view should "inherit".
```php
  @extends('app.layouts.master')
```

<h4>Session:</h4>

helper function for Session

set <br>
To set up sessions, you can do this:
```php
use System\Session\Session;

Session::set('name-session','value-session')
```

```php
with('name-session','value-session')
```

get <br>
To get the contents of the meetings, you can do this:
```php
use System\Session\Session;

Session::get('name-session')
```

```php
session('name-session')
```
remove<br>
To delete meetings, you can do the following:
```php
use System\Session\Session;

Session::remove('name-session')
```

```php
sessionRemove('name-session')
```

<h4>Helpers:</h4>

First prints the data and then continues the script.
```php
dd($users);
```
To remove html tags from data
```php
removeTags($posts->description);
```
The old function retrieves an old input value flashed into the session:
```php
old('value', 'default');

    <form action="" method="">
        <input type="text" name="emila" value="<?= old('name') ?>">
    </form>

```
Returns all errors.
```php
errors();
```
It accepts two arguments: the first is the name of the error, and the second is null by default, but it is also the value of the error.
If you only send the error name, it will return the value if there is an error with the name.
```php
error($name);
```
Returns the domain name.
```php
currentDomain();
```
To return to a page you were previously on,
```php
return back()
```
Accepts a URL and adds assets
```php
// /public/assets/css/app.css

asset('asset/css/app.css');
```
Creating a URL
```php
url($url)
```
Takes the route name and returns the URL.
```php
Route::post('/category/store',[CategoryController::class,'store'],'category.store');

route('category.store'); // http://http://{domain name}/category/store
```
Token creation

```php
generateToken($length = 32)
```
Returns the current URL.
```php
currentUrl()
```
Takes a URL and redirects you to that URL
```php
redirect()
```
Takes the route name and redirects you to that URL
```php
redirectRoute('name route')
```
To send email
```php
sendMail($emailAddress, $subject, $body)
```
To specify the HTTP verb send
```php
Route::put('/category/update/{id}',[CategoryController::class,'update'],'category.update');

    <form action="<?= route('category.update',[$category->id]) ?>" method="post">

    <?= byMethod('put')  ?>  // <input type='hidden' name='_method' value='put'>

        <input type="text" name="emila" value="<?= old('name') ?>">
        <button type="submit">send</button>

    </form>
```

<h4>Upload:</h4>

Upload a photo

```php
use System\Service\Support\Upload\Upload;

Upload::image($image)->save();
```
Specify a custom name for the photo, otherwise a default name will be used for the photo.
```php
// file /config/image.php  =>  'imageName' => time()

Upload::image($image)->name('name-image')->save();
```
Create a exclusiveDirectory directory for your photos, otherwise a default directory will be created for them.
```php
// file /config/image.php  =>  
 //  'exclusiveDirectory' => date('Y').DIRECTORY_SEPARATOR.date('m').DIRECTORY_SEPARATOR.date('d'),

Upload::image($image)->exclusiveDirectory('image')->name('name-image')->save()
```
Separate directory for images of each section
```php
// file /config/image.php  =>  'imageDirectory' => date('H_i'),

Upload::image($image)->exclusiveDirectory('image')->imageDirectory('post')
       ->name('name-image')->save()
```
You can save photos of any size you want.
```php
Upload::image($image)->exclusiveDirectory('image')->imageDirectory('post')
       ->name('name-image')->fit($width, $height)->save()
```
Delete a photo
```php
Upload::delete($imagePath);
```

<h4>Mail:</h4>

After setting up email in the Configuration section, you can easily send emails.

```php
System\Service\Support\Mail\Mail;

Mail::send($emailAddress, $subject, $body)

sendMail($emailAddress, $subject, $body)

```


<h4>Migrations:</h4>

Migrations can be defined in the database/migrations path.

```php
//   database/migrations/user.php

return 
[
    "CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `status` tinyint(5) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"

]
```
run migrations
```php
use System\Database\DBBuilder\DBBuilder;

DBBuilder::createTables();
```

<h4>Eloquent ORM:</h4>

Models are the easiest way to interact with database tables.

Models are defined in the /app/Model directory.

create a new model
```php
 php factory make:model User
```

```php
<?php
namespace App\Model;

use System\Database\ORM\Model;

 abstract class User
 {
     protected $table = 'users';
     protected $fillable= ['email','password','status'];
     protected $hidden= ['password'];
     protected $casts= [];
     protected $primaryKey= 'id';
     protected $createdAT= 'created_at';
     protected $updatedAT= 'updated_at';
     protected $deletedAT= 'deleted_at';
 }

```
Create a new record
```php
$newUser = ['email' => 'monarch@gmail.com', 'password' => 'monarch-h', 'status' => 0];

User::create($newUser);
```
update a record
```php
$update = ['id' => 1,'email' => 'monarch@gmail.com', 'password' => 'monarch-1234', 'status' => 1];

User::update($update);
```
Using where
```php
User::where('status',1)->get();
```
Using whereOr
```php
User::where('status',1)->whereOr('status','>',0)->get();
```
Using whereNull
```php
User::whereNull('email')->get();
```
Using whereNotNul
```php
User::whereNotNul('email')->get();
```
Using whereIN
```php
User::whereIN('id',[1,10])->get();
```
Using orderBy
```php
User::orderBy('id','desc')->get();
```
Using limit
```php
User::orderBy('id','desc')->limit(0,15)->get();
```
Using limit
```php
User::orderBy('id','desc')->limit(0,15)->get();
```
Using paginate
```php
// $_GET['page'] : 1

User::paginate($perPage)->get();
```

Using find
```php
User::find(1);
```

Using all
```php
User::all();
```
Using delete
```php
User::delete($id);
```

Using save
```php
$user = User::find(1);
$user->email = 'user-eamil.@gmail.com';
$user->password = 'user-password';
$user->status = 1;
$user->save();
```

Using SoftDelete
```php
use System\Database\Traits\HasSoftDelete as SoftDelete;

 abstract class User
 {
    use SoftDelete;
 }
```
<h4>Relationships:</h4>

A one-to-one relationship is a very basic type of database relationship. For example, a User model might be related to an Address model. To define this relationship, I would put an Address method on the User model. The Address method should call the hasOne method and return its result.

```php

  class User
 {
     public function address()
    {
        return $this->hasOne($model, $foreignKey ,$localKey);
    }
 }
 ```
The first argument passed to the hasOne method is the name of the related model class. Once the relationship is defined, we may retrieve the related record using Eloquents dynamic properties. Dynamic properties allow you to access relationship methods as if they were properties defined on the model:

```php
$address = User::find(1)->address();
```
A one-to-many relationship is used to define relationships where a single model is the parent to one or more child models. For example, a blog post may have an infinite number of comments. Like all other Eloquent relationships, one-to-many relationships are defined by defining a method on your Eloquent model:

```php

  class Post
 {
     public function comments()
    {
        return $this->hasMany($model, $foreignKey ,$localKey);
    }
 }
 ```
```php 
$comments = Post::find(1)->comments();
 
foreach ($comments as $comment) {
    //
}
```

To define the inverse of a hasMany relationship, define a relationship method on the child model which calls the belongsTo method:

```php
class Comment extends Model
{
    /**
     * Get the post that owns the comment.
     */
    public function post()
    {
        return $this->belongsTo($model, $foreignKey ,$localKey);
    }
}
```
Once the relationship has been defined, we can retrieve a comment's parent post by accessing the post "dynamic relationship property":

```php
$comment = Comment::find(1);
 
return $comment->post()->title;

```

<h4>Auth:</h4>

Returns the current user.
```php
Auth::user();
```
Checking if the user is logged in
```php
Auth::check();
```
Checking if the user is logged in
```php
Auth::checkLogin();
```
Login with email and password
```php
Auth::loginByEmail($email);
```
Login with id
```php
Auth::loginById($id);
```

logout
```php
Auth::logout();
```