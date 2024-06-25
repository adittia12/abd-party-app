<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $id_order
 * @property string $invoice_number
 * @property string|null $no_po_manual
 * @property string|null $period_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Invoices newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoices newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoices query()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoices whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoices whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoices whereIdOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoices whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoices whereNoPoManual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoices wherePeriodDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoices whereUpdatedAt($value)
 */
	class Invoices extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $order_number
 * @property string|null $tgl_order
 * @property string|null $company_type
 * @property string|null $name_customer
 * @property int|null $no_phone
 * @property string|null $invoice_address
 * @property string|null $delivery_address
 * @property int|null $initial_terms
 * @property string|null $jenis_term
 * @property string|null $start_event
 * @property string|null $end_event
 * @property string|null $date_pasang
 * @property string|null $warehouse
 * @property string|null $price_list
 * @property string|null $close_date
 * @property int|null $discount_rate
 * @property int|null $dp
 * @property string|null $jenis_pajak
 * @property int|null $pajak
 * @property string|null $status_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Orders newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Orders newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Orders query()
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereCloseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereCompanyType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereDatePasang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereDeliveryAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereDiscountRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereDp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereEndEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereInitialTerms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereInvoiceAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereJenisPajak($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereJenisTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereNameCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereNoPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders wherePajak($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders wherePriceList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereStartEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereStatusOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereTglOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orders whereWarehouse($value)
 */
	class Orders extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $inter_ref
 * @property string $name_product
 * @property int $sales_price
 * @property string $unit_measure
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transactions> $transaction
 * @property-read int|null $transaction_count
 * @method static \Illuminate\Database\Eloquent\Builder|Products newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Products newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Products query()
 * @method static \Illuminate\Database\Eloquent\Builder|Products whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Products whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Products whereInterRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Products whereNameProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Products whereSalesPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Products whereUnitMeasure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Products whereUpdatedAt($value)
 */
	class Products extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $id_order
 * @property int $id_product
 * @property string|null $description
 * @property int $days
 * @property int $qty
 * @property string $measure_list
 * @property int $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Orders $order
 * @property-read \App\Models\Products $product
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereIdOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereIdProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereMeasureList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transactions whereUpdatedAt($value)
 */
	class Transactions extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $user_id
 * @property string $email
 * @property string|null $join_date
 * @property string $last_login
 * @property string|null $phone_number
 * @property string|null $status
 * @property string|null $role_name
 * @property string|null $avatar
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereJoinDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserId($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $role_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole whereRoleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole whereUpdatedAt($value)
 */
	class UserRole extends \Eloquent {}
}

