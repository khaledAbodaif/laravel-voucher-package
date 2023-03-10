
![enter image description here](https://t4.ftcdn.net/jpg/03/29/10/97/360_F_329109774_iTsyjzLU5O9cagJ9UhahhNF2ZdkW4OHc.jpg)

# Laravel Voucher Package

Coupons and voucher codes checker. you can create voucher with many conditions that fit your business.

**Available Conditions**

| column | description |
|--|--|
| code | coupon or voucher code |
| is_available| check if this voucher available or not|
|max_uses|the max number of using this voucher|
|max_uses_user|the max number of using this voucher per single user|
|starts_at|start date for this voucher to be published|
|expires_at|end date for this voucher to be closed|

all of this conditions the package checking it .

> what about you have a coupon for a specific users ,vendors or customers beside the other conditions ofcourse  , or even i need to apply coupon for category , service or products all of them or specific ones  ?

**voucher_implementation_id ;)**
  this forigen id related with table takes [class path,value as json].
  you can add your voucher audience as a morph table in **voucher_audiences** that tacks which usable_type as a table name, usable_id as model id ,is_all bool that mean all records in this table and voucher_id .
  in the **voucher_implementations** table you can find the implementation record for each voucher the default one is applied .
  the default implementation just check for model table ,id or is_all check in voucher_audiences table

#  List of content

 -  Installation
 -  How Does It Work?
 -  How to use
 -  Advanced use



# Installation

    composer require khaleds/voucher

### Migrate table
    php artisan make:migration
### Seeder
Add this to your **DatabaseSeeder** class in run method
```php
	use Khaleds\Voucher\Seeder\VoucherImplementaionSeeder;
    
    $this->call(VoucherImplementaionSeeder::class);
```
  
  
# How Does It Work? 

 ### Vouchers table 
 This table contain the voucher conditions like 
| column | description |
|--|--|
| code | coupon or voucher code |
| is_available| check if this voucher available or not|
|max_uses|the max number of using this voucher|
|max_uses_user|the max number of using this voucher per single user|
|starts_at|start date for this voucher to be published|
|expires_at|end date for this voucher to be closed|

Other columns
| column | description |
|--|--|
| discount_amount | The amount to discount |
| is_fixed | Whether or not the "discount_amount" is a percentage or a fixed price |
| max_uses | Number of users that use this voucher |
| amount_cap | Amount to apply it if the price greater than cap |
| uses | The total number of uses for this voucher |

If you want more condition like specific models or ids like i want this voucher for all accounts table or users table or the users with some ids you can do that in this table

 ### Vouchers Audiences table 
 This table contain 
 | column | description |
|--|--|
| usable_type | Table name |
 | usable_id | The id that you want to use voucher |
 | voucher_id | The voucher that you want to apply this condition on it |
 | is_all | If you want to make all users in this table can use the voucher |
 

> the relation is one to many so you can add many ids if you want per voucher

 ### User Voucher table 
 This table contain the users that applied to the voucher added when you use function **apply**
# How to use

you have 2 static classes 

```php
	// $code  : voucher code
	// model  : which model uses this voucher
	// amount : the amount that you want to apply voucher on it
	// return : voucher object if passed all conditions ex if not passed 
    VoucherFactory::get(string $code,Model $user,float $amount)->check()->get()
    
    // if you pass 0 that mean the voucher applied and not used
	// applay will add the model to voucher if passes the conditions and increment uses column
    VoucherFactory::get(string $code,Model $user,float $amount)->check()->apply(1)->get()

```
### If you want to avoid all checks and apply the voucher
```php
VoucherFactory::get(string $code,Model $user,float $amount)->apply(bool $is_used, string $code, Model $model))
```

# Advanced use
> what about you have an extra conditions like you want to add voucher with only country ,service , products or categories

### Using 
```php
VoucherFactory::get(string $code,Model $user)->check()
// it tacks table name as a key and array of ids
->append(  
  [    
  "categories" => [1,2,3],  
  "products" => [1,2,3],  
  ]  
)
->apply(1)->get()
```
 you just need to add your audiences in **Vouchers Audiences table** 

 if you want to overwrite the implementation class change the class path in **voucher_implementations** table and extend from DefaultVoucher class

