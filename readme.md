![enter image description here](https://t4.ftcdn.net/jpg/03/29/10/97/360_F_329109774_iTsyjzLU5O9cagJ9UhahhNF2ZdkW4OHc.jpg)

# Laravel Voucher Package

Coupons and voucher codes checker.
you can create voucher with  many conditions that fit your besnies 

| column | description |
|--|--|
| code | coupon or voucher code |
| is_available| check if this voucher available or not|
|uses|# how many times this voucher used till now|
|max_uses|#how many times this voucher should use under any case|
|max_uses_user|#how many times this voucher should use per single user|
|voucher_implementation_id |tricky ?!!|
|starts_at|start date for this voucher to publish|
|expires_at|end date for this voucher to close it|

all of this conditions the package check for and voucher code passes to it.

> So what is the tricky thing ?!
> what about you have a coupon for a specific users ,vendors or customers beside the other conditions ofcourse  , or even i need to apply coupon for category , service or products all of them or specific ones  ?

**voucher_implementation_id ;)**
  this forigen id related with table takes [class path,value as json].
  you can add your voucher audience as a morph table in **voucher_audiences** that tacks which usable_type as a table name, usable_id as model id ,is_all bool that mean all records in this table and voucher_id .
  in the **voucher_implementations** table you can find the implementation record for each voucher the default one is applied .
  the default implementation just check for model table ,id or is_all check in voucher_audiences table

#  List of content

 - Installation
 - How to use
 - Implementation
 - OC Principle
 -  Tips


# Installation

    composer require khaleds/voucher

# How to use

you have 2 static classes 

```php
	//factory class to get witch implementation class you want
	//check for defualt conditions
	// return the voucher
    VoucherFactory::get(string $code,Model $user)->check()->get()
    
    // if you pass 0 that mean the voucher applied and not used
	// applay will add the model to voucher if passes the conditions and increment uses column
    VoucherFactory::get(string $code,Model $user)->check()->apply(1)->get()

```
```php
    //return all typs for this voucher
    // like products,users,categories
    VoucherAudience::types(int $voucherId)->get()
    
    //return array of all records for that table
    VoucherAudience::usersTable(string $table)->get()
    
```

> you can use 
> VoucherFactory::get(string $code,Model $user)->applay(bool $is_used, string, Model $model)) if you want to avoid all checks

# OC Principle

as you can see i am just handling default voucher maybe you have different implementation for  the voucher per category or service .
so as open closed principle you should't edit or add on my package to place your implementation you should extends VoucherAbstract which have abstract method append and default function (apply,check,get) you can polymorphism any function you want or use append class to take arguments
and apply any condition you want .
**steps**

 - add record in voucher_implementations takes class path ,value as json array 
 - add voucher record with your implementation id 
 - happy Voucher ;)

# Tips

 1. `Ctrl+Alt+Shift+U` in my package src/services with phpStorm ide to see uml diagram to understand the flow
 2. `phpmyadmin` operations/designer to see erd diagram to understand the schema
 

> you can use this 2 things in your daily work to understand others code will
>  
