<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{User,Scooter,SparePart,Review,BlogPost,Setting};
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder {
    public function run(): void {
        User::create(['name'=>'Admin','email'=>'admin@greenwheelev.com','password'=>Hash::make('Admin@123'),'role'=>'admin']);
        $scooters = [
            ['EcoRider X1','city','🛵','80 km','45 km/h','4 hrs','1.2 kW',75000,'Best Seller',true,'City-perfect electric scooter'],
            ['SpeedStar S2','highspeed','⚡','100 km','70 km/h','5 hrs','2.5 kW',110000,'Popular',true,'High performance urban commuter'],
            ['GreenMile LR','longrange','🏍️','150 km','55 km/h','6 hrs','2.0 kW',135000,'Long Range',false,'Best in class range'],
            ['UrbanPro P3','premium','✨','120 km','65 km/h','4 hrs','3.0 kW',155000,'Premium',true,'Luxury electric experience'],
            ['CityZip C1','city','🛵','70 km','40 km/h','3 hrs','1.0 kW',62000,'Budget',false,'Affordable city commuter'],
            ['DeliveryPro D1','delivery','📦','90 km','45 km/h','4 hrs','1.5 kW',85000,'Commercial',false,'Built for business'],
        ];
        foreach($scooters as [$n,$cat,$ico,$rng,$spd,$chr,$pwr,$prc,$tag,$feat,$desc]) {
            Scooter::create(['name'=>$n,'slug'=>Str::slug($n),'category'=>$cat,'icon'=>$ico,'range'=>$rng,'top_speed'=>$spd,'charging_time'=>$chr,'motor_power'=>$pwr,'price'=>$prc,'tag'=>$tag,'is_featured'=>$feat,'description'=>$desc,'is_active'=>true]);
        }
        $parts = [
            ['48V 24Ah Lithium Battery','battery','🔋',8500,10000,50,'Original'],
            ['60V 20Ah Battery Pack','battery','🔋',11000,13500,30,'Original'],
            ['Universal EV Charger 48V','electrical','🔌',1200,1600,100,'Compatible'],
            ['60V BLDC Motor Controller','electrical','⚡',2800,3500,45,'Original'],
            ['Electric Hub Motor 350W','electrical','⚙️',4500,5500,20,'Original'],
            ['Throttle Assembly Kit','electrical','🎮',450,600,200,'Compatible'],
            ['Front Disc Brake Set','mechanical','🛞',680,850,80,'Original'],
            ['Rear Shock Absorber Pair','mechanical','🔩',1100,1400,60,'Compatible'],
            ['Digital Speedometer Display','electrical','📊',850,1100,70,'Original'],
            ['Wiring Harness Complete','electrical','🔗',1350,1700,35,'Original'],
            ['LED Headlight Assembly','accessories','💡',680,900,90,'Compatible'],
            ['EV Scooter Tyre 90/90-12','mechanical','⭕',1200,1500,40,'Original'],
            ['Side Stand Assembly','mechanical','🔧',320,450,120,'Original'],
            ['Phone Holder + USB Charger','accessories','📱',550,750,150,'Accessory'],
            ['EV Waterproof Body Cover','accessories','🧥',480,650,75,'Accessory'],
            ['BMS Protection Board 48V','electrical','🛡️',950,1200,55,'Original'],
        ];
        foreach($parts as [$n,$cat,$ico,$prc,$mrp,$stk,$tag]) {
            SparePart::create(['name'=>$n,'slug'=>Str::slug($n),'category'=>$cat,'icon'=>$ico,'price'=>$prc,'mrp'=>$mrp,'stock'=>$stk,'tag'=>$tag,'is_active'=>true]);
        }
        $reviews = [
            ['Rahul Patel','Nadiad, Gujarat',5,'Excellent service and very knowledgeable staff. Got my EV scooter serviced here and the difference in performance is amazing. Highly recommended!'],
            ['Priya Shah','Anand, Gujarat',5,'Bought my first electric scooter from Green Wheel EV. The team was very helpful in explaining all features and finance options. Love my new EV!'],
            ['Vijay Mehta','Kheda, Gujarat',4,'Got genuine spare parts at great prices. The online ordering process was smooth and delivery was on time. Will buy again!'],
            ['Neha Patel','Nadiad, Gujarat',5,'Amazing dealership! Test ride experience was wonderful. Got great EMI deal. Highly satisfied with purchase.'],
        ];
        foreach($reviews as [$n,$loc,$rat,$rev]) Review::create(['name'=>$n,'location'=>$loc,'rating'=>$rat,'review'=>$rev,'is_approved'=>true]);
        $blogs = [
            ['Top 5 Benefits of Switching to Electric Scooters in 2025','top-5-benefits-electric-scooters','Discover why thousands of Indians are making the switch to electric scooters this year.','<p>Electric scooters are revolutionizing urban transport in India...</p>','EV Guide',true],
            ['How to Maintain Your EV Battery for Maximum Life','maintain-ev-battery','Learn the best practices to extend your electric scooter battery life by up to 50%.','<p>Your EV battery is the most important component...</p>','Battery Tips',true],
            ['Government EV Subsidies in Gujarat 2025','gujarat-ev-subsidies-2025','Complete guide to FAME-II and Gujarat state subsidies available for EV buyers.','<p>The Gujarat government offers attractive subsidies...</p>','Policy',true],
        ];
        foreach($blogs as [$t,$sl,$ex,$ct,$cat,$pub]) BlogPost::create(['title'=>$t,'slug'=>$sl,'excerpt'=>$ex,'content'=>$ct,'category'=>$cat,'is_published'=>$pub,'published_at'=>now()]);
        $settings_data = ['site_name'=>'Green Wheel EV','phone'=>'+91 7984304504','email'=>'greenwheelev03@gmail.com','address'=>'Near Riya Party Plot, Piplag Road, Nadiad, Gujarat','whatsapp'=>'917984304504','razorpay_key_id'=>'YOUR_RAZORPAY_KEY_ID','free_shipping_above'=>'500','shipping_charge'=>'80','business_hours'=>'Mon-Sat: 9:00 AM – 7:00 PM'];
        foreach($settings_data as $k=>$v) Setting::set($k,$v);
    }
}
