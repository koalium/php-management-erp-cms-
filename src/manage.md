{
(list view as lv):  header: title and btn add new ; body: list selectable scrollable paginated, icon btn open edit remove for each row ;  form to add or edit selected save update remove or cancel ;
}

{
don't ever implement or create or script , any kind of documentation or guide or describe about what to do or what done , never ever create and write anuthing like readme or md or doc or guide or achievement thing ;
just focus on the code developing and implementing to achive asked for that in your code not anywhere else!
}

{زبان فارسی پیش فرض
its defaults language farsi persian at each level and at all section and in every aspect default complete persian farsi ;
}

{تاریخ شمسی جلالی به عنوان ورودی و نمایش 
default date jalali date;
default calendar jalali calendar;
(default datepicker jalali datepicker;)
default datepicker persian jalali datepicker;
default timepicker jalali farsi time picker;
default input for date : graphical interactive jalali datepicker;
jalali datepicker with jalali year , jalali months names farsi , jalali day name farsi , jalali weekend farsi جمعه, jalali week start day شنبه ، jalali iran farsi holiday;
date show default jalali date shown with jalali year and month and jalali date ;
jalali_datepicker.js
jalali.css
jalali_timepicker.js
persian_datepicker.js
persian_timepicker.js
jalali.php 

}

{
its very safe and check security , validation both at fron and backends, sql injection , other code or injection or .... , secure and safe at math and devision , data validation and type also its size and.... to be safe and confidence;
}

{
at each file :if user not auth or signed in:   if not index : 404.html , if at index :  sign in formi;
do not create 404.html , i had it ;
}

,
{
./router.php

because using folder and subdirectories, its need to route the files and correctly path , relative address failed and its or something like it must implementing;
}

,

{
خروج
./logout.php
session destroy when user logout , or after 1 hour automatic and user need sign again;
}
,
{
/db/ folder for database depends:
{
./dbc.php is used just for connecting to mysqldb: esmartis_erp , user: esmartis_user , pass: esmartis1364; control and handle and comunicate through it to database just by its functions;
at each of any other files never use sql code and sql codes just used in it ;
}

{
./dbi.php for database migration , creating tables if not exists 
}

{
./dbd.php contain all def data, insert ignored 
defaults:
lang : farsi
theme : dark blue
setting: setting.json

}
}
,
{
at each file call without its permissions just direct to 404.html , 
if not signed in or ...;
if not permission to access !
do not create 404.html;
}
,
{/assets/ folder
style.css : predefined colors background for each theme default gradient of diffrent colors , 
specific text colors
specific card 
border
shadow
depend on theme dark or medium or light
then use them to better style bootstrap on lines
}
,

{/ start point base
./index.php main and start file ;
}
,
{/auth/ folder
فرم ورود
./sign.php : inputs: username , password , btn sign ;validation inputs, limitations 3 seconds between attempts at backend, 
if user valid and found :
 if password valid :
  if confirmed: 
    if admin : 
     ./admin/admin.php 
    else: ./dashboard/dashboard.php ;
sign has remember me capability;
apim.php api manager
api.php backend working
}
,
{ /assets/ folder
هدر پویا
./header.php has header inside it and used by others to create header ;
for each user , according to its needs , header item and... , dynamic creating live and care of address and path to when using where it and where point to be correct;

apim.php for its needs and menus...
}
,
{/assets/ folder
فوتر پویا
./footer.php to create and handle footer that had copyright for eSmartis and designed by Ashkarian.R;
its dynamic creating depend on where who when creating, can carry more options and features for admin or completely different feature and view and options for ceo and admin and managers to carry more usable info for them;
as like as recent request or warning for checkpay or project or about that department features;
footer_api.php
}
,
{ادمین
at its directory at ./admin/
if has permission 
admin.php is it admin panel : lv of users icon btn open remove permissions for each existed user; لیست کاربران
admin_api.php 

users.php lv of
user.php فرم کاربر
form user add edit remove active reactive .... ,
apim.php api manager 
user_api.php

permissions.php مجوزها lv of
 permission.php
form permissions :فرم مجوزهای کاربر list view of permissions and sections with 3 radio btn as group write read none for each access or section snd btn reset , save , ...;
permission_api.php ;
api.php api manager

log form to check its logs ;
another section to seend lv of system log and activity , database and other security and health checks; also can change its own password ; default admin: user: admin , pass: 654321 ;,ceo , 654321;, cto , 654321,; reza,123456; change user passwords ; form user input user , password , active ، delete , btn savd , remove , update , cancel ,;
logs.php

departments.php lv of
department.php crud form its...
system.php of system health and figure and issue , 
category.php
apim.php as api manager
api.php for each of files need backend 
}
،
{داشبورد dynamic dashboard
./dashboard/ folder for customization of user its dashboard,
if has permission
dashboards.php card lv of mini view of user created customized and saved dashboard ,
each user has one default predefined dashboard , user can add new or and edit and save dashboard , user can choose its default use and default dashboard from list , 
dashboard.php dynamic creating for and depend on user permissions and predefine and or customized from database...;
dashboard_form.php is the form to add new or and edit save update remove new or selected dashboard of user, 
dashboard_items.php lv of 
dashboard_item.php crud form of item that user can add and combine to create its dashboard;
dashboard item as di :{
card view as cv : card with intractive rising border unique color gradient and reactions
event cv  di,
task cv di,
meeting cv is di
budget cv di,
employee cv di,

}
dashboard_api.php
apim.php as api manager
api.php for each of files need backend 
هر کاربر دشبورد ویژه و قابل شخصی سازی خود را دارد
کاربر بسته به مجوز دسترسی هایی که داشته یک داشبورد ابتدایی برایش به عنوان پیش فرض و به شکل پویا ساخته میشود
کاربر میتواند بخش هایی را به داشبورد خود اضافه کند
کاربر میتواند محا قرارگیری اجزای داشبورد را جا به جا کند
رنگ بندی و اولویت بندی ها را تغییر دهد
بخش هایی را حذف و ویرایش کند
و همه تغییرات را به عنوان یکی لز داشبوردهایش ذخیره کند
و طبق تنظیم داشبورد مشخصی همواره به او نمایش داده میشود.
setting.php
setting_api.php
apim.php as api manager
api.php for each of files need backend 

pre implement these dashboard for its users and insert ignore dashboard, user and its needs and creat tables if not exists
dashboard, user , password = 654321;
ceo default dadhboard , ceo ,;
president default dashboard, president,;
vp default dashboard,vp,;
admin default dashboard,admin,;
financial default dashboard,finman,;
procurement default dashboard,procman,;
project default dashboard,projman,;
hr default dashboard,hrman,;
marketing default dashboard,markman,;
warehouse default dashboard,whman,;
qc default dashboard,qcman,;
production default dashboard,prodman,;
engineering default dashboard,engiman,;
secretary default dashboard, secretary,;
cto default dashboard,cto, ;
executive assistant default dashboard, exassist,;
office default dashboard, office,;
transport default dashboard, transman,;
security default dashboard, secureman,;
hse default dashboard, hseman , ;
each one just permissions to its part as its department section ,  its calendar, its events , its notes , its chats , its notif , its message, its dashboard, very well defined data and accessibility and permissions 
permissions 
user permissions 
very well rich defenition 
dashboards.php lv of
dashboard_form.php customized and crud dashboard 
dashboard.php dynamic specific created dashboard for each user
apim.php as api manager
api.php for each of files need backend 

}
,
{/setting/ folder 
settings.php
setting.php : font type , language def persian , theme def dark , color specific : form gradient dark violet , table dark olive , card specific each and border rised , reactive , interactive, very rich visual feedback;
profile.php
apim.php as api manager
api.php for each of files need backend 

}
,


{مخاطبین 
if has permission
./contacts/ folder for contact feature
user had its own:
contacts.php lv of contact, form for it..;
contact.php فرم مخاطب
contact is important , it can be person or company or organization or... , in each it has its soecific property of it, then multiple emails phones mobiles faxes addresses websites social and images and info and notes , it can be purchaser or vendor suppliers or customer employee or ....;
it can had notes or comments and categories in related ;
contact_api.php;
categories.php
category.php
apim.php as api manager
api.php for each of files need backend 
}
,
{یادداشت
at ./note/ directory:
if has permission
notes.php lv of private notes of that specific user 
can shared with others;
note_api.php;
دفتر یادداشت
notbook.php is rich content notepad platform specific user to ...;
notbook_api.php;
user specific 
وایت برد
whiteboards.php lv of White board that
تخته نقاشی و قابل اشتراک گذاری به شکل زنده
whiteboard.php very advance interactive sharing whiteboard with features and enhance ui ux as typing, drawing , drag and drop , push image , get image of , sketch on it and can painting by colors and can change its background color , share it as multiple user live used it at meeting or ...
whiteboard_api.php;
categories.php
category.php
apim.php as api manager
api.php for each of files need backend 

}

{تقویم
at calendar folder ./calendar/
user specific 
if has permission
تقویم گرافیکی فارسی و جلالی 
calendar.php its graphical rich visual feedbacks of dare picking 
calendar_api.php
user had its own:
 event handling event.php  setting event 
todo.php as to do lists ,
 adding  comment  ,label ,reminders to selected day,  
jalali as default datetime persian farsi jalali , day name jalali ,  month jalali ,years jalali , highlight current day , 
different color holiday defaults iran holiday;
شروع هفته روز  شنبه و پایان هفته روز جمعه ، ماه اول فروردین 
events.php lv of event , 
ثبت و ویرایش و تنظیم و حذف رویدادها با تقویم گرافیکی فارسی جلالی با نام روز و ماه فارسی و واکنش دهنده و لمسی
event.php form add or and edit event save update remove;;
event_api.php;
apim.php as api manager
api.php for each of files need backend 

user had its own:
./todo.php ایحاد و پیگیری و تکمیل و... کارهای روزانه و زمانبندی آنها مطابق با تقویم و تاریخ شمسی و جلالی و فارسی گرافیکی و زیبا
todo_api.php;
user had its own:
یادآور
reminders.php lv of remind...
reminder.php تنظیم و ایجاد و یادآورها در ارتباط با موضوعات و بخش ها و امکان استفاده از تقویم و تاریخ گرافیکی فارسی جلالی و نمایش به تاریخ فارسی جلالی
reminder_api.php;
apim.php as api manager
api.php for each of files need backend 
categories.php
category.php
}

{
تاریخ و ورود تاریخ به شکل گرافیکی و جلالی و فارسی
date input :always graphical  jalali datepicker  ;
time  input : always graphical timepicker jalali in charge ;
date output: always jalali date shown;
datetime: jalali as default;
calendar: jalali as default;
}
,
{
مالی : 
at financial folder ./financial/
دارای زیر بخش های حسابداری و بودجه و مدیریت مالی 
financial.php : as financial dashboard for
financial_api.php
apim.php as api manager
api.php for each of files need backend 

 financial management with sections:
 { حسابداری
حسابها
accounts.php : as financial section , list view of accounts for transaction between them , btn add new ;
account.php حساب
    form account: add new or and edit selected account with all inputs and ... save update remove ;
      account: bank , cash , wallet , custom , etc... each has its own input and spec as ;

        {bank: list of bank name with its prop and info;
apim.php as api manager
api.php for each of files need backend }

        {currency: irr as default, usd , eur , ...;
apim.php as api manager
api.php for each of files need backend }
        account category ,
        account owner can be none or one or multiple of contact that existed or creating and saving and using here;
apim.php as api manager
api.php for each of files need backend 
        {bank account , type , hesab , shaba , can related to none or one or multiple bank cards ;
apim.php as api manager
api.php for each of files need backend }
        {bank card: bank , type , card number , iban , ... , related to none of one or multiple accounts , related to none or one or multiple contacts;
apim.php as api manager
api.php for each of files need backend }
        wallet : name , blockchain name , address , owner one or none or multiple contact , token , info , attachments;
        custom account: for accountant, like cash , تنخواه ، گاوصندوق ، کیف پول ، صندوق و...
 ;
account can owned by one of multiple contact;
apim.php as api manager
api.php for each of files need backend 
}
{تراکنش‌ها 
  transactions.php : list view of transactions , pagination, scrollable, selectable, button add new ;
transaction.php فرم تراکنش
    form transaction: add new or and edit transaction , save update remove ...;
      transaction : transfer, income, expense , .... ;  draft , send , confirm , cancelled; reserved with checkpay check number payed one date of reservation;
from payer account, to payed account , amount , currency used , requested by , created by , creation time, confirmation time , resevation date ,....; purpose and tag attachment category and verifiers...; with comment and relation can added;
apim.php as api manager
api.php for each of files need backend 
}
,
{
دفتر حساب
ledger.php for accountant and ledger account and transactions ...;
apim.php as api manager
api.php for each of files need backend 
}
{بودجه
budgets.php lv of budget row and
budget.php فرم ردیف بودجه
 form ..., comparison with real data from ... and also budget planning for week 2week 4week 13 week and 26week and 52week ...
apim.php as api manager
api.php for each of files need backend 
}
{
banks.php lv of bank 
bank.php form to add edit update remove bank;
currencies.php lv of currency 
currency.php for to crud it
apim.php as api manager
api.php for each of files need backend 
}
categories.php
category.php
apim.php as api manager
api.php for each of files need backend 
end of financial
}

{پروژه
at project folder ./project/
projects.php lv of project , 
form projectDetails فرم مشخصات پروژه
 project items فرم آیتم های پروژه
project management بخش مدیریت پروژه, project engineering بخش مهندسی پروزه
, project control بخش کنترل پروژه features and capability,
collabrations.php lv of collabration.php with its 
members.php lv of the member.php form crud
implementing کارگروه to implement and select members addiition to it to related to project by specific permissions an specific
apim.php as api manager
api.php for each of files need backend 

tasks.php وظایف 
task.php فرم وطیفه with schedule and ...that work on specific project.
requests.php for requests and taskreport.php گزارش انجام وظیفه یا شرح کار that reported task and its condition by addin comments and ...
taskcategory.php
project_api.php
task_api.php
apim.php as api manager
api.php for each of files need backend 
{
بخش صورت وضعیت پیمان به عنوان بخشی از برخی پروژه ها که صورت وضعیت نیاز دارند و به شکل نزدیکی با بخش های قرارداد و مالی و مهندسی در تعامل و جریان میباشند
ایجاد صورت وضعیت جدید
ثبت صورت وضعیت 
اصلاح صورت وضعیت موجود
اعمال خط خوردگی 
تغییر وضعیت از در حال نوشتن به تکمیل و ارسال و تایید با خط خوردگی و تایید مشاور و دریافت پول و..
ثبت صورت وضعیت تعدیل
درخواست تعدیل
ایجاد مصالح جدید در صورت وضعیت
وارد کردن لیست مصالح 
وارد کردن قیمت های مصوب
ضرایب تعدیل سالانه
ضرایب ویژه و موضوعی
ضرایب اعلامی سازمان
صورت وضعیت ماقبل آخر
صورت وضعیت پایانی
گزارش اختلاف
گزارش پیشرفته
ثبت فاکتور و پیش فاکتور و قراردادها 
ثبت و الصاق و ضمایم و اسناد 
کتابچه تکمیلی
finalbooks.php lv of
finalbook.php form to crud
finalbook_api.php
apim.php as api manager
api.php for each of files need backend 
}
اسناد پروژه
قراردادهای پروژه
کارفرما 
پیمانکار 
بودجه بندی 
مهندسی و اجرا
و...
پروژه با همه بخش ها در تعامل و ارتباط میباشد و مدیر پروژه به موضوعات مختلف مربوط به پروژه دسترسی دارد
اسناد و مکاتبات و...categories.php
category.php
apim.php as api manager
api.php for each of files need backend 
end of project;
}

{امور قرارداد
at contract folder ./contract/
contracts.php قرارداد lv of contracts as contracts dashboard center; 
contract.php فرم قرارداد contract form to add new or and edit and save update removd contract ;
category.php
contract_api.php
apim.php as api manager
api.php for each of files need backend 
}

{منابع انسانی
at hr folder ./hr/
hr.php as human resources department and management, calc and send wages , leaves , personal data , Phish of wage , debt , loan , resign , employee management, tax , bime , hire , fire ,and all other paper work... , employee can use owned code and user to send request for leave at each and other things request that needs at
employee.php that take them these features and capabilities to their requesting ...
پس در بخش نیروی انسانی ، درخواست استخدام ، فرم مصاحبه ، فرم استخدام ، استعفا ، محاسبه حقوق ، مرخصی ، غیبت ، جریمه ، عیدی و سنوات و بیمه و مالیات ، انواع مرخصی ساعتی و روزانه و.... ، وام و مساعده و صندوق و...، مدارک پرسنلی و...انواع تاییدیه طب کار و پرونده پرسنلی و تمامی امور نیروی انسانی و پرسنل ثبت و ضبط و نگهداری و پیگیری و انجام میگردد.
so i carry 
payroll.php
timesheet.php 
wages.php
personal.php
documents.php
requests.php
request.php
responds.php
respond.php
category.php
leave_requests.php
hr_api.php
apim.php as api manager
api.php for each of files need backend 
}

{انبار
at warehouse folder ./warehouse/
if has permission
each warehouse has its specific manager and permission 
warehouses.php to manage multiple warehouse.php of multiple site or ...
دارای چندین انبار : اصلی ، پای کار ، زایعات ، پروژه ، الکترونیک و قابل افزودن و ویرایش بودن انبار
چندین انباردار با مجوز دسترسی مشخص به انبار خاص 
تعریف کالای جدید و کد انبار جدید
ویرایش کد و مشخصات کالای تعریف شده
ثبت و ورود به انبار
ثبت خروج از انبار
دریافت درخواست متریال و کالا
درخواست تاییدیه خروج
درخواست خرید 
رسید تحویل به انبار
رسید خروج و تحویل از انبار
تایید و ثبت بارنامه
اعلام گزارش موجودی
جابه جایی
دسته بندی و زیر دسته
طبقه بندی
ثبت درخواست کالا از طرف
ثبت امضا و رسید
ایجاد رسید و پیش فاکتور و تمپلیت
transfers.php lv of
transfer.php form crud
in.php
out.php
transactions.php
preforms.php
items.php
item.php
requests.php
request.php
responds.php
respond.php
warehouses.php lv of
warehouse_form crud form
warehouse.php dashboard
apim.php api middle ware management 
categories.php
category.php
input , output , transfer internal , external , new product assignment , verification for output and export, add new stuff, edit present , categories and sub categories, reports , بارنامه ، دریافت امضا ، رسید انبار ، تعریف کالای جدید ، دسته بندی ، طبقه بندی ، ورود و خروج و جابه جایی ، انبار اصلی و پایه کار و زایعات و برقی و پروژه و ... ، مجوز خروج ، درخواست کننده و ثبت ضبط ، گزارش کمبود و یا اخطار با حد مشخص برای هر کالا یا نوع یا دسته تا آلارم دهد ، ارسال درخواست خرید کمبود ها طبق mr به بخش تدارکات ، کمبودهای درخواست متریال با موجودی انبار تبدیل به درخواست خرید و جهت تامین تدارکات ارسال...
کالای جدید میتواند کلی فایل و ضمیمه هم داشته باشد
categories.php
category.php
warehouse_api.php
apim.php as api manager
api.php for each of files need backend 
end of warehouse 
}

{تدارکات
at procurement folder ./procurement/
if has permission
precurement.php lv of price request, lv of buy requests that confirmed by its manager or ...; each item open done and responded at its form as getting pricd
دو بخش درخواست قیمت و درخواست خرید:
لیست درخواست قیمت 
که هر آیتم را باز کند مشروح را دیده و پس از استعلام قیمت و دریافت پیس فاکتور ، قیمت و پیش فاکتور را به عنوان پاسخ آن درخواست قیمت میچسباند بهش و ثبت میکند و کار انجام شده و پاسخ داده شده و دیگر به وی نشان داده نمیشود.
لیست درخواست های خرید تایید شده که برای خرید هرکدام هماهنگی را تکمیل کرده و با پیشفاکتور تایید شده نهایی تبدیل به پاسخ آن کرده و ثبت و ذخیره و ارسال میکند 
که توسط بخش مالی مشاهده و جهت پرداخت با تایید مدیریت پرداخت میشود
requests.php
request.php
responds.php
respond.php
categories.php
category.php
procurement_api.php
apim.php as api manager
api.php for each of files need backend 
}

{مهندسی
at engineering folder ./engineering/
if has permission
engineering.php داشبورد اصلی بخش مهندسی
انجام طراحی ها
دریافت درخواست طراحی
ایجاد محصول جدید
products.php محصولات
product.php فرم محصول برای ایجاد و ویرایش محصول و زیر محصول تا قطعه
هر محصول دارای چند زیر محصول است
هر زور محصول دارای چند زیر محصول است
در نهایت دارای چند قطعه میشود
apim.php as api manager
api.php for each of files need backend 
parts.php as lv of 
part.php قطعه تک جزیی است
ایجاد قطعه جدید
ویرایش قطعات موجود 
apim.php as api manager
api.php for each of files need backend 

MTO ایجاد مربوط به و ورژن دار
mtos.php lv of 
mto.php
BOM ایجاد مربوط به... و ورژن آن
boms.php lv of
bom.php
apim.php as api manager
api.php for each of files need backend 

اسناد فنی به شکل ورژن دار 
درخواست اصلاح اسناد فنی
ایحاد و اصلاح سند با ورژن جدید
product created by: combination : multiple parts , multiple product , mto , bom , mr , drawing , qc forms , production procedure, documents and..... all related and can be in related prev predicted and implemented for any purpose and used to its developing;
apim.php as api manager
api.php for each of files need backend 

پیشنهاد ها شامل پیشنهاد فنی و مالی و نهایی ...
proposals.php : lv of proposal that prepared as technical or overall or commercial or final...
proposal.php ,فرم ایجاد پیشنهاد یا ویرایش پیشنهاد
 آن
production.php as dashboard of production department
apim.php as api manager
api.php for each of files need backend 

ncrs.php as lv of
ncr.php فرم عیب و بعد پروسه و اصلاح و....
production.php تولید به عنوان بخش مرکزی و داشبورد دپارتمان تولید
work_order.php ابلاغ کار یا ابلاغ دستور کار یا دستور کار
work_report.php گزارش کار که شامل موضوعی و یک سری هم گزارش روزانه مجزا داریم که رصد و کمک میباشد
apim.php as api manager
api.php for each of files need backend 

productdetail.php جزییات محصول
products.php لیستی با امکانات جهت محصولات
product.php فرم افزودن ویرایش محصول که شامل زیر محصول ها و زیر محصول های زیر محصول ها تا رسیدن به قطعات و قطعه میشود
parts.php lv of part 
part.php form add edit remove save update parts spec and prop..
drawings.php نقشه های محصولات و قطعات و...
drawing.php form to edit add remove update save drawing;
material request:
mrs.php as lv of
mr.php form for
material_request.php درخواست متریال جهت کار و با پروژه و موضوع مربوط توسط شخص ایجاد میشود و به انبار ارسال شده تا تعیین وضعیت سود

apim.php
api.php


procedures.php lv of
procedure.php form crud it for each work, product process and....
engineering_api.php
product_api.php
apim.php as api manager
api.php for each of files need backend 

end of engineering!
}

{/planning/
planning.php dashboard for planning 
plans.php lv of
plan.php
apim.php as api manager
api.php for each of files need backend 
schedules.php
schedule.php
timesheets.php
control.php
....
apim.php
api.php
end of planning
}

,
{/production/ folder برای بخش تولید
if has permission
production.php
ncrs.php lv of
ncr.php as it form
workflow.php جریان را روند کار ها
workorders.php
workorder.php
requsts.php lv of
request.php as form درخواست برای اصلاح یا متریال خاصی از انبار و اصلاح mr
درخواست اصلاح نقشه 
apim.php as api manager
api.php for each of files need backend 
درخواست و ثبت پروسه تولید جدید و یا ویرایش و اصلاح آنها
تایید دریافت ابلاغ کار
گزارش کار روزانه
گزارش پیشرفت کار موردی
اعلام نیازمندی های تولید و کمبودها
اعلام تکمیل کار
ویرایش بندی کلیه اسناد و مدارک و استفاده از ویرایش یکسان در تمام بخش ها و دپارتمان ها
procedures.php lv of
procedure.php form crud it for each work, product process and....
production_api.php
apim.php
api.php
end of production 
}
,
,
{/qc/ folder for
if has permission
apim.php as api manager
api.php for each of files need backend 
qc.php به عنوان مرکز کنترل کیفیت 
qcs.php lv of qc workings
qcforms.php as lv of
qcform.php فرم های کنترل کیفیت به شکل موردی و تمپلیت آماده شده و پرپسه آن نیز ایحاد شده یا به شکل عکس و اسکن افزوده میشود
inspections.php lv of
inspection.php form crud inspection result
qcprocedures.php as lv of
qcprocedure.php form of crud its data inputs...
qcplans.php lv of
qcplan.php برنامه کنترل کیفی
apim.php as api manager
api.php for each of files need backend 

inspection test plan:
itps.php lv of
itp.php پلن و برنامه تست و پرپسجر آن با فرم های پیش آماده و با ایحاد فرم جدید برای موضوع و چسباندن به
qc_api.php
api.php
apim.php
end of qc
}
,

{بخش بازرگانی
at marketing folder ./marketing/

if has permission
apim.php as api manager
api.php for each of files need backend 
marketing.php به عنوان داشبورد مرکزی بخش بازرگانی

sell.php برای داشبورد و مرکز بخش فروش

tenders.php مناقصات lv of 
tender.php ....
لیست مناقصات شناسایی شده که قصد شرکت در آنها را داریم و در مسیر بررسی هستند
tender فرم مناقصه برای ایجاد و ثبت شناسایی مناقصه جدید و... tender form to add edit remove

ثبت مناقصه شناسایی شده
درخواست بررسی فنی مناقصه
فرم های پیگیری
پاسخ پیشنهادات
درخواست مدارک
پاسخ به درخواست ها
مناقصه پس از تایید مدیریت جهت بررسی به بخش مهندسی میرود
پس از کار مهندسی با تایید مدیر مهندسی و مدیریت به بخش تدارکات جهت مشخص شدن قیمت به شکل درخواست قبمت میرود
پاسخ درخواست قیمت توسط بخش مدیریت و مهندسی تبدیل به پیشنهاد نهایی و تصمیم و قیمت نهایی میشود و به بخش فروش ارسال میشود
بخش فروش پیشنهادات و ... را دریافت و مطابق آنها پیگیر شرکت در مناقصه میشود
جهت تامین هزینه شرکت در مناقصه با دستور مدیر بخش مالی هزینه مربوط را پرداخت میکند.
apim.php as api manager
api.php for each of files need backend 
در صورت برنده شدن در مناقصه نتیجه به بخش مدیریت ارسال میشود
با تصمیم مدیریت مدیر پروژه و ... جهت آن تعیین و به عنوان پروژه تعریف شده و به بخش پروژه منتقل میشود
marketing_api.php
apim.php
api.php
end of marketing 
}

at calendar
{افزودن به صورت گرافیکی به تقویم گرافیکی جلالی با توجه به انتخاب هر روز و امکان ویرایش یا افزودن به آن
events.php lv of event with farsi jalali date gui and رویدادها را طبق تقویم و تاریخ ایرانی فارسی جلالی تنظیم و مشاهده کردن
event.php form add edit remove event ;
event_api.php
todos.php lv of 
todo.php بخش کارهای روزانه
apim.php as api manager
api.php for each of files need backend 
reminders.php lv of pre created reminder for reminding at jalali persoan date time
reminder.php form add or and edit remove یادآور را ایجاد و تنظیم کردن
}


{پیامرسان داخلی
at message folder ./msg/
if has permission
apim.php as api manager
api.php for each of files need backend 
user specific owned:
messenger.php
چت گروهی برای اعضا و گروه ها و مکاتبات درونی
chats.php
chat.php
chatroom.php
groupchat.php
privatechat.php
پیغام استفاده شده در پیام رسان و چت ها
messages.php
message.php
shares.php
share.php
groups.php lv of
group.php crud its
members.php lv of
member.php crud it
امکان ایجاد چت گروهی چند نفره و اشتراک وایت بورد به آن
امکان ارسال و اشتراک فایل و متن و صوت و تصویر
امکان تایپ و پیغام با جلب توجه 
امکان امضا و تایید صورت جلسه نهایی در آن
messenger_api.php
chat_api.php
apim.php
api.php
end of messenger 
}

{مدیریت جلسات
at meeting folder ./meeting/
if has permission
apim.php as api manager
api.php for each of files need backend 
specific for user but has related system to connect and relate them
meetings.php lv of documents of meeting and dashboard for 
meeting.php crud form ... management,
فرم و ایجاد و ویرایش جلسه و تکمیل آن که در نهایت با امضا صورت جلسه یک رونوشت آن به صندوق همه اعضا شرکت کننده میرود و میاوانند در بخش صورتجلسات خودشان آن را مشاهده کنند
meeting.php form add or edit remove meeting documents and decision around...
هر جلسه موضوع و..... و با تاریخ و تقویم فارسی جلالی ثبت و ضبط میشود
خلاصه برداری
اعضای حاضر
صورت حلسه نهایی
ثبت و ضبط و امضا و ذخیره و 
امکان امضای دیجیتال
خروجی برای پرینت
دریافت و ذخیره عکس و فایل افزونه
تنظیم جلسات بعدی
scripts.php
script.php
categories.php
category.php
meeting_api.php
apim.php
api.php
end of meetings
}


{اعلان
at folder ./notif/
if has permission
apim.php as api manager
api.php for each of files need backend 
user specific its own:
notifications.php
لیست اعلان ها با اولویت و وضعیت و خلاصه و امکان باز کردن و ثبت و در بخی موارد پاسخ دادن و ویرایش و حذف و بایگانی و...
notification.php form 
notification_api.php
apim.php
api.php
}


{

workflows.php روند های کاری
روند کاری شرکت در مناقصه:
در ابتدا مناقصه شناسایی شده ./tenders.php در لیست مناقصات گزینه افزودن مناقصه جهت بررسی ./tender.php فرم مناقصه جهت بررسی 
مشخصات و فایل های ضمیمه و درخواست ها و هزینه و... را وارد کرده و یک مناقصه جهت بررسی ایجاد میشود.
مناقصه جهت بررسی توسط ceo یا مدیریت یا مدیر عامل یا کسی که مجوز آن را دارد جهت ارجاع به واحد مهندسی تایید میشود.
پس از ارجاع به واحد مهندسی: به عنوان درخواست بررسی تایید شده ، بخش مهندسی آن را کامل کرده و mto bom design و تکنیکال پروپوزال را آماده کرده و به آن ضمیمه میکند ، در بخش هایی که نیاز به دریافت قیمت و پیشفاکتور هست به صورت اتوماتیک تیک زده و به عنوان درخواست قیمت در میز بخش تدارکات قرار میگیرد
بعد از پاسخ و تعیین قیمت بخش تدارکات به عنوان پاسخ درخواست قیمت ، پیشنهاد آماده و به عنوان پیشنهاد در میز مدیریت قرار میگیرد
با تایید مدیریت یا سخص مجوز دار پیشنهاد جهت ارسال به عنوان پیشنهاد نهایی به بخش بازرگانی میرود
و هزینه های لازم شرکت در آن به بخش مالی میرود
و با تایید مدیریت و پرداخت هزینه ها بخش بازرگانی با اسناد در مناقصه شرکت میکند.

نتیجه مناقصه متعاقبا توسط بازرگانی ثبت و در اختیار مدیریت قرار میگیرپ.
}
,
{/hse/ folder for hse department 
if has permission
apim.php as api manager
api.php for each of files need backend 
hse.php dashboard for hse 
لیست فرم ها
فرهای نمونه
موردی
بخش دپارتمان hse , و تمام ملزومات و نیازها و بخش ها و فایلهایش را که نیاز دارد ذیل همین ایحاد کن
ثبت سوانح 
نامه به بیمه و گزارش 
گزارش آمبولانس یا انتظامی در صورت نیاز و ثبت آن 
صورتجلسه حوادث و...
پیگیری بهداشت و طب کار و محیط زیست و استاندارد های مرتبط
hse_api.php
hse_forms.php
hse_form.php
reports.php
report.php
categories.php
category.php
apim.php
api.php
end of hse
}
,
{/transport/ folder for
if has permission
apim.php as api manager
api.php for each of files need backend 
transport.php
بخش حمل و نقل و شیپینگ
راننده ها و رفت و آمد
مسیر ها و تحویل و گرفتن
مدیریت امور حمل و نقل
سرویس حمل و نقل کارکنان
حمل و نقل صنعتی و امورات مربوط به آن
راننده های همراه با خودرو و تقسیم کار آنها
امور مربوطه در ارتباط بت سایر بخش های مرتبط و لازم
برگه ماموریت
برگه تحویل
رسید دریافت و ارسال
امکان رهگیری و....
transport_api.php
apim.php
categories.php
api.php
tracking.php
apim.php
end of transportation 
}
,
{/security/ folder for نگهبان 
if has permission
apim.php as api manager
api.php for each of files need backend 
security.php
reports.php
report.php
images.php
image.php
warnings.php
warning.php
بخش مربوط به نگهبانان
ثبت تمامی ورود و خروج ها
ثبت اتفاقات و هشدارها
گزارش روزانه
شیفت مربوطه
اتصال به دستگاه ساعت زنی و سینکرون و آپدیت بخش ورود و خروج پرسنلی توسط api مربوطه در بخش hr جهت اتصال به دستگاه ساعت زنی و ورود و خروج های ثبت شونده خودکار توسط رابط آن
امکان درخواست ماشین و آژانس و ثبت آن به هزینه شرکت و ارسال درخواست آن به بخش مربوطه مالی و حسابداری
لیست مجوزهای ورود مشاهده میشود که در هر روز چه اشخاصی مجوز ورود از چه ساعتی تا چه ساعتی را داشته و این موارد توسط مدیران مربوط به هر بخش و با تایید تکمیل و قابل مشاهده است
لیست ممنوع الورود ها با رنگ متفاوت
لیست انتظار در مواقعی که منتظر مهمان هستند
فرم و رسید ورود و تحویل به مهمان و دریافت و ثبت آن هنگام خروج از مهمان یا شخص ...
security_api.php
category.php
reports.php
report.php
happeneds.php
happen.php
apim.php
api.php
end of security 
}
,
{/client/ folder 
if has permission
apim.php as api manager
api.php for each of files need backend 
client.php داشبورد معمولی افراد که به این بخش دسترسی دارند و شرایط عضویت آنها متفاوت است و یوزرنیم و پسووردشان میتواند ۱ حرف و یک عدد باشد 
requests.php لیست درخواست‌ها 
request.php فرم درخواست

timesheets.php حضور و غیاب و ورود و خروج ثبت شده
timesheet.php فرم آن
امکان درخواست مرخصی ساعتی
امکان دیدن ساعات ورود و خروج و مرخصی و ماموریت و غیبت
امکان درخواست مرخصی استحقاقی
مرخصی...
دیدن فیش حقوقی
اصلاح و درخواست اصلاح ساعت ورود و خروج اشتباه یا فراموش شده و ثبت آنها که باید به تایید مدیر مربوطه برسد تا در نهایت اصلاح شود
امکان دیدن مانده مرخصی و 
تمان چیزهای مربوط به یک نیروی انسانی که به بقیه سامانه دسترسی ندارد.
درخواست وام
درخواست تاییدیه
بیمه
و...
leaverequests.php
leaverequest.php

client_api.php
apim.php
api.php
end of client 
}
,
{
each user can develop some template for its job like:
qc form templates
itp template 
ncr template 
inspection temp
product template 
procedures template 
designing template 
drawing
wage calculator or personal form
admin can add new item to header or completely new section and department later and can developing it according to its needs 
anyone can change its calendar, date , lang , theme , font , font size , color , background, dashboard style, dashboard features , according to its...
also
profiles.php
and profile.php form for each user
settings.php

template_api.php
}
overall and user specialist:
categories.php
category.php
category_api.php
{/search/ folder:
if has permission
search.php as very advance with highly special filters and category and everything around any of specific 
all searching are aquire in user specific region that had permissions for and can access to
search_api.php
filter_api.php
apim.php as api manager
api.php for each of files need backend 
}

{
/setting/ folder for
apim.php as api manager
api.php for each of files need backend 
setting.php for user change its language, theme , customization for each component and features and characteristic according to its permissions and needs...

profile.php user profile and..

apim.php
api.php

}

