### Create the Laravel PHP project

```bash
$ composer create-project laravel/laravel bronies-api --prefer-dist
...
$ cd bronies-api
```

### Configure the database

Update `database.php` to use `sqlite3`

```php
'default' => 'sqlite',
```

### Create the bronies table and model

```bash
$ php artisan migrate:make create_bronies_table
Created Migration: 2014_07_17_012154_create_bronies_table
Generating optimized class loader
Compiling common classes
Compiling views
```

Modify the generated migration as follows:

    <?php

    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateBroniesTable extends Migration {

    	/**
    	 * Run the migrations.
    	 *
    	 * @return void
    	 */
    	public function up()
    	{
    		Schema::create('bronies', function(Blueprint $table)
    		{
    			$table->increments('id');

    			$table->string('name', 255);
    			$table->string('email', 255);
    			$table->integer('pony_name');

    			$table->timestamps();
    		});
    	}

    	/**
    	 * Reverse the migrations.
    	 *
    	 * @return void
    	 */
    	public function down()
    	{
    		Schema::drop('bronies');
    	}

    }


Then run the migration:

```bash
$ php artisan migrate
**************************************
*     Application In Production!     *
**************************************

Do you really wish to run this command? y
Migration table created successfully.
Migrated: 2014_07_17_004427_create_bronies_table
```

### Create model at `app/models/Bronie.php`:

```php
<?php

class Bronie extends Eloquent {

}
```

### Create controller

```bash
$ php artisan controller:make BronieController
```

### Add Bronies to routes

```php
...
Route::resource('bronies', 'BronieController');
```

You can verify the routes with the artisan command `routes`:

    $ php artisan routes
    +--------+---------------------------------+-----------------+--------------------------+----------------+---------------+
    | Domain | URI                             | Name            | Action                   | Before Filters | After Filters |
    +--------+---------------------------------+-----------------+--------------------------+----------------+---------------+
    |        | GET|HEAD bronies                | bronies.index   | BronieController@index   |                |               |
    |        | GET|HEAD bronies/create         | bronies.create  | BronieController@create  |                |               |
    |        | POST bronies                    | bronies.store   | BronieController@store   |                |               |
    |        | GET|HEAD bronies/{bronies}      | bronies.show    | BronieController@show    |                |               |
    |        | GET|HEAD bronies/{bronies}/edit | bronies.edit    | BronieController@edit    |                |               |
    |        | PUT bronies/{bronies}           | bronies.update  | BronieController@update  |                |               |
    |        | PATCH bronies/{bronies}         |                 | BronieController@update  |                |               |
    |        | DELETE bronies/{bronies}        | bronies.destroy | BronieController@destroy |                |               |
    +--------+---------------------------------+-----------------+--------------------------+----------------+---------------+

### Seed the database

You can seed the database by adding the following code into the `run` function of `DatabaseSeeder.php`:

```php
Eloquent::unguard();

DB::table('bronies')->delete();

Bronie::create(array( 'name'      => 'Yehuda Katz',
                      'email'     => 'yehuda@emberjs.com',
                      'pony_name' => 'Apple Star' ));
Bronie::create(array( 'name'      => 'Tom Dale',
                      'email'     => 'tom@emberjs.com',
                      'pony_name' => 'Blade Thunder' ));
Bronie::create(array( 'name'      => 'Peter Wagenet',
                      'email'     => 'peter@emberjs.com',
                      'pony_name' => 'Strong Gunner' ));
Bronie::create(array( 'name'      => 'Trek Glowacki',
                      'email'     => 'trek@emberjs.com',
                      'pony_name' => 'Veiled Steel' ));
Bronie::create(array( 'name'      => 'Erik Bryn',
                      'email'     => 'erik@emberjs.com',
                      'pony_name' => 'Defiant Perfection' ));
Bronie::create(array( 'name'      => 'Kris Seldon',
                      'email'     => 'kris@emberjs.com',
                      'pony_name' => 'Magical Drop' ));
Bronie::create(array( 'name'      => 'Stefan Penner',
                      'email'     => 'stefan@emberjs.com',
                      'pony_name' => 'Heroic Fire' ));
Bronie::create(array( 'name'      => 'Leah Silber',
                      'email'     => 'leah@emberjs.com',
                      'pony_name' => 'Radiant Aura' ));
Bronie::create(array( 'name'      => 'Alex Matchneer',
                      'email'     => 'alex@emberjs.com',
                      'pony_name' => 'Midnight Rainbow' ));
Bronie::create(array( 'name'      => 'Robert Jackson',
                      'email'     => 'robert@emberjs.com',
                      'pony_name' => 'Charged Sprout' ));

$this->command->info('Bronie table seeded!');
```

Next, run the seed:

```bash
$ php artisan db:seed
```

### View the bronies JSON

```bash
$ php artisan serve
$ open http://localhost:8000/bronies
```

Modify the function `index` of the `BronieController` to return the list of bronies:

```php
public function index()
{
  $bronies = Bronie::all();
  return Response::json(array('bronies' => $bronies));
}
```

Now open up the browser and refresh!

### Store

Add the following into your `store` function:

```php
public function store()
{
  $rules = array(
    'name'       => 'required',
    'email'      => 'required|email',
    'pony_name'  => 'required'
  );

  $validator = Validator::make(Input::all(), $rules);

  if ($validator->fails()) {
    return Response::json(array('errors' => $validator->messages()));

  } else {
    $bronie = new Bronie;
    $bronie->name       = Input::get('name');
    $bronie->email      = Input::get('email');
    $bronie->pony_name  = Input::get('pony_name');
    $bronie->save();

    return Response::json(array('bronie' => $bronie));
  }
}
```

You can test this out using cURL:

```bash
curl -i \
     -X POST \
     -H "Accept: applicaton/json" \
     -d "" \
     http://localhost:8000/bronies
```

The prior cURL request will return an error response because of missing required params. Let's try with all required fields:

```bash
curl -i \
     -X POST \
     -H "Accept: applicaton/json" \
     -d "name=Eric&email=cavneb@gmail.com&pony_name=Stallion" \
     http://localhost:8000/bronies
```

Now you can revisit the browser and it should return data when visiting /bronies

### Show a record

Add the following to the `show` function:

```php
public function show($id)
{
  $bronie = Bronie::find($id);

  if ($bronie) {
    return Response::json(array('bronie' => $bronie));

  } else {
    return Response::make(NULL, 404);
  }
}
```

### Update records

Add the following to the `update` function:

```php
public function update($id)
{
  $rules = array(
    'name'       => 'required',
    'email'      => 'required|email',
    'pony_name'  => 'required'
  );

  $validator = Validator::make(Input::all(), $rules);

  if ($validator->fails()) {
    return Response::json(array('errors' => $validator->messages()));

  } else {
    $bronie = Bronie::find($id);

    if ($bronie) {
      $bronie->name       = Input::get('name');
      $bronie->email      = Input::get('email');
      $bronie->pony_name  = Input::get('pony_name');
      $bronie->save();
      return Response::json(array('bronie' => $bronie));

    } else {
      return Response::make(NULL, 404);
    }
  }
}
```

You can test this out with the cURL command:

```bash
curl -i \
     -X PUT \
     -H "Accept: applicaton/json" \
     -d "name=John&email=john@gmail.com&pony_name=Taco" \
     http://localhost:8000/bronies/1
```

### Delete a Bronie, yo!

Add the following into the `destroy` function:

```php
public function destroy($id)
{
  $bronie = Bronie::find($id);
  if ($bronie) {
    $bronie->delete();
    return Response::make(NULL, 202);
  } else {
    return Response::make(NULL, 404);
  }
}
```

You can test this out with the cURL command:

```bash
curl -i \
     -X DELETE \
     http://localhost:8000/bronies/1
```
