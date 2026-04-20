<?php

namespace Database\Seeders;

use App\Models\CustomerReview;
use App\Models\DesignTool;
use App\Models\Faq;
use App\Models\Partner;
use App\Models\PortfolioItem;
use App\Models\WhyChoosePoint;
use App\Models\User;
use App\Models\WebsiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        CustomerReview::query()->delete();
        DesignTool::query()->delete();
        Faq::query()->delete();
        Partner::query()->delete();
        PortfolioItem::query()->delete();
        WhyChoosePoint::query()->delete();

        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'MAHAR Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        WebsiteSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'hero_kicker_en' => 'Digital marketing · Social-first growth',
                'hero_kicker_my' => 'ဒစ်ဂျစ်တယ် မာကတ်တင်း · လူမှုမီဒီယာ ဦးစားပေး တိုးတက်မှု',
                'hero_title_en' => 'Grow your brand where your audience scrolls.',
                'hero_title_my' => 'ပရိသတာ ရှိနေသော နေရာမှာ ဘရန်းကို တိုးချဲ့ပါ။',
                'hero_subtitle_en' => 'MAHAR Digital Marketing plans and runs Facebook and TikTok campaigns — from branding assets and monthly content to video production and performance reporting. Edit all copy from the admin panel.',
                'hero_subtitle_my' => 'MAHAR Digital Marketing သည် Facebook နှင့် TikTok ကမ်ပိန်းများကို စီစဉ်ပြီး လုပ်ဆောင်ပါသည် — ဘရန်း အပိုင်းအစများ၊ လစဉ် အကြောင်းအရာ၊ ဗီဒီယို ထုတ်လုပ်မှု နှင့် စွမ်းဆောင်ရည် အစီရင်ခံစာအထိ။ စာသားအားလုံးကို စီမံခန့်ခွဲမှု ပန်နယ်မှ ပြင်ဆင်နိုင်ပါသည်။',
                'hero_cta_primary_label_en' => 'Download profile (PDF)',
                'hero_cta_primary_label_my' => 'ပရိုဖိုင် PDF ရယူရန်',
                'hero_cta_primary_url' => null,
                'hero_cta_secondary_label_en' => 'View services',
                'hero_cta_secondary_label_my' => 'ဝန်ဆောင်မှုများ ကြည့်ရန်',
                'hero_cta_secondary_url' => '/#marketing-services',
                'portfolio_heading_en' => 'Selected design',
                'portfolio_heading_my' => 'ရွေးချယ်ထားသော ဒီဇိုင်း',
                'portfolio_intro_en' => 'Campaigns, social content, and brand systems we have shipped — click a cover to zoom or open the full case study.',
                'portfolio_intro_my' => 'ကမ်ပိန်း၊ လူမှုမီဒီယာ အကြောင်းအရာ နှင့် ဘရန်း စနစ်များ — ပုံကို ချဲ့ကြည့်ရန် နှိပ်ပါ။',
                'contact_heading_en' => 'Talk to MAHAR Digital Marketing',
                'contact_heading_my' => 'MAHAR Digital Marketing နှင့် စကားပြောကြပါ',
                'contact_intro_en' => 'Tell us about your brand, platforms (Facebook / TikTok), and goals. We reply within two business days.',
                'contact_intro_my' => 'ဘရန်း၊ ပလက်ဖောင်း (Facebook / TikTok) နှင့် ရည်မှန်းချက်များကို ဖော်ပြပါ။ ရုံးသတ်မှတ်ရက်များ ၂ ရက်အတွင်း ပြန်လည်ဆက်သွယ်ပေးပါမည်။',
                'contact_email' => 'hello@mahardigitalmarketing.test',
                'contact_phone' => '+95 9 000 000000',
                'contact_address_en' => "Yangon Creative District\nStudio 4B",
                'contact_address_my' => "ရန်ကုန်၊ ဖန်တီးမှုနယ်မြေ\nစတူဒီယို ၄ ဘီ",
                'contact_hours_en' => 'Mon – Fri: 09:00 – 18:00',
                'contact_hours_my' => 'တနင်္လာ – သောကြာ: ၀၉၀၀ – ၁၈၀၀',
                'partnership_heading_en' => 'Partnerships',
                'partnership_heading_my' => 'ပူးပေါင်းဆောင်ရွက်မှု',
                'partnership_body_en' => 'Featured partners on the home page carousel. Update logos and links anytime in Admin.',
                'partnership_body_my' => 'ပင်မစာမျက်နှာရှိ ကာရူဆယ်တွင် ပြသသော ပူးပေါင်းဖက်များ။ လိုဂိုနှင့် လင့်ခ်များကို Admin မှ အချိန်မရွေး ပြင်ဆင်နိုင်ပါသည်။',
                'faq_heading_en' => 'Frequently asked questions',
                'faq_heading_my' => 'မေးလေ့ရှိသော မေးခွန်းများ',
                'faq_intro_en' => 'Quick answers about timelines, deliverables, and how we run Facebook and TikTok work with you.',
                'faq_intro_my' => 'အချိန်ဇယား၊ ပေးအပ်မှုများ နှင့် Facebook၊ TikTok ဝန်ဆောင်မှုများကို ဘယ်လို လုပ်ဆောင်မည်ဆိုသည့် အကြောင်း။',
                'footer_tagline_en' => 'MAHAR Digital Marketing — Facebook, TikTok, and performance-led campaigns for modern brands.',
                'footer_tagline_my' => 'MAHAR Digital Marketing — ခေတ်မီ ဘရန်းများအတွက် Facebook၊ TikTok နှင့် စွမ်းဆောင်ရည်ဦးစားပေး ကမ်ပိန်းများ။',
                'footer_copyright_en' => 'MAHAR Digital Marketing',
                'footer_copyright_my' => 'MAHAR Digital Marketing',
                'social_facebook' => 'https://facebook.com',
                'social_telegram' => 'https://t.me',
                'social_viber' => 'https://www.viber.com',
                'social_tiktok' => 'https://www.tiktok.com',
            ]
        );

        $projects = [
            ['slug' => 'aurora-coffee-brand', 'title_en' => 'Aurora Coffee identity', 'title_my' => 'Aurora ကော်ဖီ အမှတ်တံဆိပ်', 'category_en' => 'Branding', 'category_my' => 'ဘရန်း', 'accent_color' => '#7c3aed'],
            ['slug' => 'pulse-festival', 'title_en' => 'Pulse festival campaign', 'title_my' => 'Pulse ပွဲတော်ကမ်ပိန်း', 'category_en' => 'Campaign', 'category_my' => 'ကမ်ပိန်း', 'accent_color' => '#db2777'],
            ['slug' => 'northline-editorial', 'title_en' => 'Northline editorial system', 'title_my' => 'Northline အယ်ဒီတိုရီယယ်', 'category_en' => 'Editorial', 'category_my' => 'အယ်ဒီတိုရီယယ်', 'accent_color' => '#0ea5e9'],
            ['slug' => 'kite-mobile-app', 'title_en' => 'Kite finance app UI', 'title_my' => 'Kite ငွေကြေး အက်ပ် UI', 'category_en' => 'Digital', 'category_my' => 'ဒစ်ဂျစ်တယ်', 'accent_color' => '#22c55e'],
            ['slug' => 'loom-packaging', 'title_en' => 'Loom skincare packaging', 'title_my' => 'Loom အသားအရေ ထုပ်ပိုးမှု', 'category_en' => 'Packaging', 'category_my' => 'ထုပ်ပိုးမှု', 'accent_color' => '#f97316'],
            ['slug' => 'signal-poster', 'title_en' => 'Signal typographic poster', 'title_my' => 'Signal စာလုံးပုံ ပိုစတာ', 'category_en' => 'Print', 'category_my' => 'ပရင့်ထုတ်', 'accent_color' => '#eab308'],
        ];

        foreach ($projects as $i => $data) {
            PortfolioItem::query()->updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'title_en' => $data['title_en'],
                    'title_my' => $data['title_my'],
                    'summary_en' => 'Concept exploration, grid systems, and final artwork — built for production-ready handoff.',
                    'summary_my' => 'စိတ်ကူးယဉ်၊ ဂရစ် စနစ်နှင့် အပြီးသတ် အနုပညာလက်ရာ။',
                    'category_en' => $data['category_en'],
                    'category_my' => $data['category_my'],
                    'accent_color' => $data['accent_color'],
                    'image_path' => 'demo-portfolio/'.$data['slug'].'.jpg',
                    'sort_order' => $i,
                    'is_published' => true,
                ]
            );
        }

        $faqs = [
            [
                'question_en' => 'How long does a Facebook or TikTok campaign take to launch?',
                'question_my' => 'Facebook သို့မဟုတ် TikTok ကမ်ပိန်း စတင်ဖို့ ဘယ်လောက်ကြာလဲ။',
                'answer_en' => 'After assets and access are ready, most monthly content plans go live within 1–2 weeks. Video production batches depend on scripts and shoot days — we agree milestones in the kickoff call.',
                'answer_my' => 'ပစ္စည်းများနှင့် အကောင့် ဝင်ရောက်ခွင့် ပြင်သွင်းပြီးပါက လစဉ် အကြောင်းအရာ အစီအစဉ်များကို ပုံမှန် ၁–၂ ပတ်အတွင်း စတင်နိုင်ပါသည်။ ဗီဒီယို ထုတ်လုပ်မှုသည် စာသားနှင့် ရိုက်ကူးရက်များပေါ် မူတည်ပါသည်။',
            ],
            [
                'question_en' => 'Do you work with clients outside Myanmar?',
                'question_my' => 'မြန်မာပြင်ပ ဖောက်သည်များနှင့် လုပ်ကိုင်ပါသလား။',
                'answer_en' => 'Yes. We run remote-first collaboration — shared calendars, cloud folders, and structured async updates so campaigns stay on schedule.',
                'answer_my' => 'ဟုတ်ကဲ့။ အဝေးမှ ပူးပေါင်းဆောင်ရွက်မှု — ပြက္ခဒိန်၊ cloud ဖိုလ်ဒါ နှင့် တည်ငြိမ်သော async အပ်ဒိတ်များ။',
            ],
            [
                'question_en' => 'What files are included at handoff?',
                'question_my' => 'လက်ခံရရှိချိန်တွင် ဖိုင်များ ဘာတွေပါသလဲ။',
                'answer_en' => 'Organized Figma libraries, PDF brand guidelines, print-ready exports, and motion references when applicable.',
                'answer_my' => 'စနစ်တကျ Figma၊ PDF လမ်းညွှန်ချက်များ၊ ပရင့်အဆင်သင့် ထုတ်ယူမှုများ ပါဝင်ပါသည်။',
            ],
            [
                'question_en' => 'How do revisions and rounds of feedback work?',
                'question_my' => 'ပြင်ဆင်မှုနှင့် တုံ့ပြန်မှု အကြိမ်ရေများ ဘယ်လိုလုပ်သလဲ။',
                'answer_en' => 'Each phase includes agreed revision rounds (typically two per milestone). Extra rounds can be scoped as a small add-on so timelines stay predictable.',
                'answer_my' => 'အဆင့်တစ်ခုစီတွင် သဘောတူထားသော ပြင်ဆင်မှု အကြိမ်ရေ (ပုံမှန် milestone တစ်ခုလျှင် နှစ်ကြိမ်) ပါဝင်ပါသည်။ အကြိမ်ထပ်မံများကို အချိန်ဇယား တည်ငြိမ်စေရန် ထပ်ဆောင်းခန့်မှန်းနိုင်ပါသည်။',
            ],
            [
                'question_en' => 'What is your pricing structure?',
                'question_my' => 'စျေးနှုန်း စနစ် ဘယ်လိုလဲ။',
                'answer_en' => 'Projects are usually fixed-fee by phase with a clear scope document. For exploratory work, a discovery sprint can be quoted separately.',
                'answer_my' => 'ပရောဂျက်များကို အဆင့်လိုက် fixed-fee နှင့် ရှင်းလင်းသော scope စာတမ်းဖြင့် လုပ်ဆောင်ပါသည်။ ရှာဖွေစူးစမ်းမှုအတွက် discovery sprint ကို ခွဲ၍ ကိုးကားနိုင်ပါသည်။',
            ],
            [
                'question_en' => 'Can you adapt existing brand guidelines?',
                'question_my' => 'ရှိပြီးသား ဘရန်း လမ်းညွှန်ချက်များကို ဆက်လက်သုံးနိုင်ပါသလား။',
                'answer_en' => 'Yes. I can extend established grids, color, and type systems while keeping production partners aligned on specs and exports.',
                'answer_my' => 'ဟုတ်ကဲ့။ ရှိပြီးသား grid၊ အရောင် နှင့် စာလုံးစနစ်များကို ဆက်လက်တိုးချဲ့ပြီး ထုတ်လုပ်ရေးဖက်များနှင့် spec နှင့် export များ ကိုက်ညီအောင် ထိန်းနိုင်ပါသည်။',
            ],
            [
                'question_en' => 'Do you collaborate with developers or printers?',
                'question_my' => 'ဒေဗလပါများ သို့မဟုတ် ပရင့်တိုက်များနှင့် ပူးပေါင်းပါသလား။',
                'answer_en' => 'Often. I supply annotated files, asset naming, and export presets so implementation or print production stays smooth.',
                'answer_my' => 'မကြာခဏပါ။ ဖော်ပြချက်ပါ ဖိုင်များ၊ asset အမည်ပေးခြင်းနှင့် export preset များ ပေးအပ်ပါသည်။',
            ],
            [
                'question_en' => 'What do you need from me to get started?',
                'question_my' => 'စတင်ရန် ဘာတွေလိုအပ်ပါသလဲ။',
                'answer_en' => 'A short brief, links to references you like, audience notes, and any must-keep constraints (logos, legal, accessibility).',
                'answer_my' => 'တိုတောင်းသော brief၊ ကြိုက်နှစ်သက်သော ကိုးကားချက်များ၊ ပရိသတ်အကြောင်း နှင့် မဖြစ်မနေ ထိန်းသိမ်းရမည့် ကန့်သတ်ချက်များ။',
            ],
            [
                'question_en' => 'How do payments and deposits work?',
                'question_my' => 'ငွေပေးချေမှု နှင့် အကြိုငွေ ဘယ်လိုလဲ။',
                'answer_en' => 'A deposit secures the calendar; remaining invoices are tied to agreed milestones. Terms are confirmed in writing before work begins.',
                'answer_my' => 'ကြိုတင်ငွေဖြင့် ပြက္ခဒိန် သေချာစေပြီး ကျန်ငွေများကို သဘောတူထားသော milestone များနှင့် ချိတ်ဆက်ပါသည်။ လုပ်ငန်းမစမီ စာရင်းဖြင့် အတည်ပြုပါသည်။',
            ],
            [
                'question_en' => 'What if the project scope changes mid-way?',
                'question_my' => 'ပရောဂျက် scope အလယ်မှာ ပြောင်းလဲရင် ဘယ်လိုလဲ။',
                'answer_en' => 'We pause, document the new scope, and agree on timeline and fee adjustments before continuing — no surprise scope creep.',
                'answer_my' => 'ခေတ္တရပ်ပြီး scope အသစ် မှတ်တမ်းတင်ကာ ဆက်လုပ်မီ အချိန်နှင့် ကြေးညှိနှိုင်းပါသည် — မမျှော်လင့်ထားသော scope တိုးချဲ့မှုမရှိစေရန်။',
            ],
        ];

        foreach ($faqs as $i => $row) {
            Faq::query()->create([
                ...$row,
                'sort_order' => $i,
                'is_published' => true,
            ]);
        }

        $whyChoose = [
            ['title_en' => 'Performance-led planning', 'title_my' => 'စွမ်းဆောင်ရည်ဦးစားပေး စီစဉ်မှု', 'body_en' => 'We set clear KPIs for reach, engagement, and conversions before spend goes live — so every boost has a reason.', 'body_my' => 'ကြိုတင် ရည်မှန်းချက်များ သတ်မှတ်ပြီးမှ ကုန်ကျစရိတ်သုံးပါသည်။'],
            ['title_en' => 'Platform-native creative', 'title_my' => 'ပလက်ဖောင်း အလိုက်ဖက် ဖန်တီးမှု', 'body_en' => 'Content is shaped for Facebook feeds and TikTok formats — aspect ratios, hooks, and motion that fit each channel.', 'body_my' => 'Facebook နှင့် TikTok အတွက် သင့်တော်သော ပုံစံ၊ အချိန်နှင့် လှုပ်ရှားမှု။'],
            ['title_en' => 'Transparent reporting', 'title_my' => 'ရှင်းလင်းသော အစီရင်ခံစာ', 'body_en' => 'Monthly insight summaries and campaign snapshots you can share with stakeholders — no black boxes.', 'body_my' => 'လစဉ် ခွဲခြမ်းစိတ်ဖြာချက်နှင့် ကမ်ပိန်း အကျဉ်းချုပ်။'],
            ['title_en' => 'End-to-end campaigns', 'title_my' => 'အဆုံးသတ် ကမ်ပိန်း', 'body_en' => 'From brand assets and calendars to paid support and video production — one team aligned on your growth goals.', 'body_my' => 'ဘရန်း ပစ္စည်းများ၊ ပြက္ခဒိန်၊ paid ပံ့ပိုးမှု နှင့် ဗီဒီယိုအထိ တစ်တပ်တည်းညီ။'],
        ];
        foreach ($whyChoose as $i => $row) {
            WhyChoosePoint::query()->create([
                'title_en' => $row['title_en'],
                'title_my' => $row['title_my'],
                'body_en' => $row['body_en'],
                'body_my' => $row['body_my'],
                'icon' => null,
                'sort_order' => $i,
                'is_published' => true,
            ]);
        }

        $reviews = [
            ['author_en' => 'Maya Chen', 'author_my' => 'မာယာ ချန်', 'role_en' => 'Marketing lead, Aurora Coffee', 'role_my' => 'ကမ်ပိန်း ဦးဆောင်၊ Aurora Coffee', 'body_en' => 'Clear process, fast iterations, and the brand system still feels bold a year later. Exactly the partner we needed.', 'body_my' => 'ရှင်းလင်းသော လုပ်ငန်းစဉ်၊ မြန်ဆန်သော ပြင်ဆင်မှုနှင့် ဘရန်းစနစ် တစ်နှစ်ကြာထိ ထူးခြားနေဆဲ။', 'rating' => 5],
            ['author_en' => 'James Okonkwo', 'author_my' => 'ဂျိမ်းစ် အိုကွန်ကွို', 'role_en' => 'Founder, Pulse Festival', 'role_my' => 'တည်ထောင်သူ၊ Pulse Festival', 'body_en' => 'Campaign visuals landed on time for launch week. Great communication and attention to small typographic details.', 'body_my' => 'ကမ်ပိန်း ပုံများ စတင်အပတ်တွင် အချိန်မှီ ပြီးပါသည်။ ဆက်သွယ်မှုကောင်းပြီး စာလုံးအသေးစိတ် ဂရုစိုက်မှု။', 'rating' => 5],
            ['author_en' => 'Sofia Alvarez', 'author_my' => 'ဆိုဖီယာ အယ်ဗာရက်ဇ်', 'role_en' => 'Product, Kite Finance', 'role_my' => 'ထုတ်ကုန်၊ Kite Finance', 'body_en' => 'UI kit was organized for engineering handoff — naming, states, and edge cases were already thought through.', 'body_my' => 'အင်ဂျင်နီယာလက်ခံမှုအတွက် UI kit စနစ်တကျ၊ အမည်ပေးခြင်းနှင့် အခြေအနေများ စဉ်းစားပြီး။', 'rating' => 5],
            ['author_en' => 'Hnin Wai', 'author_my' => 'နှင်းဝေ', 'role_en' => 'Studio manager, Loom Skincare', 'role_my' => 'စတူဒီယို မန်နေဂျာ၊ Loom', 'body_en' => 'Packaging proofs were meticulous; print shop had almost zero rework. Would collaborate again on the next line.', 'body_my' => 'ထုပ်ပိုးမှု proof များ စိတ်ရှည်ရှည်ဖြင့်၊ ပရင့်တိုက်တွင် ပြန်လုပ်စရာ နည်းပါသည်။', 'rating' => 5],
            ['author_en' => 'Daniel Park', 'author_my' => 'ဒန်နီယယ် ပါ့ခ်', 'role_en' => 'Creative director, Signal Posters', 'role_my' => 'ဒီဇိုင်း ညွှန်ကြားရေးမှူး၊ Signal', 'body_en' => 'Poster series had real personality without losing legibility on large format — rare balance.', 'body_my' => 'ပိုစတာ စီးရီးတွင် ကိုယ်ပိုင်အမူအရာ ရှိပြီး ဖတ်ရလွယ်ပါသည်။', 'rating' => 4],
        ];
        foreach ($reviews as $i => $row) {
            CustomerReview::query()->create([
                'author_en' => $row['author_en'],
                'author_my' => $row['author_my'],
                'role_en' => $row['role_en'],
                'role_my' => $row['role_my'],
                'body_en' => $row['body_en'],
                'body_my' => $row['body_my'],
                'rating' => $row['rating'],
                'sort_order' => $i,
                'is_published' => true,
            ]);
        }

        $partners = [
            ['name_en' => 'Northwind Studio', 'name_my' => 'နော့သ်ဝင်းစတူဒီယို', 'url' => 'https://www.behance.net/'],
            ['name_en' => 'Pixel & Paper', 'name_my' => 'ပစ်ဇယ် နှင့် စာရွက်', 'url' => 'https://dribbble.com/'],
            ['name_en' => 'Orbit Labs', 'name_my' => 'အော်ဘစ် လက်ဘ်', 'url' => 'https://www.figma.com/'],
            ['name_en' => 'Lumen Agency', 'name_my' => 'လူမန်အေဂျင်စီ', 'url' => 'https://www.adobe.com/'],
            ['name_en' => 'Studio Kite', 'name_my' => 'စတူဒီယို ကိုက်', 'url' => 'https://www.blender.org/'],
            ['name_en' => 'Field & Form', 'name_my' => 'ဖီးလ် နှင့် ဖောင်', 'url' => 'https://www.sketch.com/'],
        ];

        foreach ($partners as $i => $row) {
            Partner::query()->create([
                'name_en' => $row['name_en'],
                'name_my' => $row['name_my'],
                'logo_path' => 'demo-partners/'.$i.'.jpg',
                'website_url' => $row['url'],
                'sort_order' => $i,
                'is_published' => true,
            ]);
        }

        $devIcon = 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons';
        $stack = [
            ['name_en' => 'Figma', 'name_my' => 'Figma', 'category_en' => 'UI · Prototyping', 'category_my' => 'UI · နမူနား', 'logo' => $devIcon.'/figma/figma-original.svg', 'url' => 'https://www.figma.com/'],
            ['name_en' => 'Adobe Illustrator', 'name_my' => 'Adobe Illustrator', 'category_en' => 'Vector · Identity', 'category_my' => 'ဗက်တာ · အမှတ်တံဆိပ်', 'logo' => $devIcon.'/illustrator/illustrator-original.svg', 'url' => 'https://www.adobe.com/products/illustrator.html'],
            ['name_en' => 'Adobe Photoshop', 'name_my' => 'Adobe Photoshop', 'category_en' => 'Photo · Compositing', 'category_my' => 'ဓာတ်ပုံ · ပေါင်းစပ်', 'logo' => $devIcon.'/photoshop/photoshop-original.svg', 'url' => 'https://www.adobe.com/products/photoshop.html'],
            ['name_en' => 'Adobe After Effects', 'name_my' => 'Adobe After Effects', 'category_en' => 'Motion · Video', 'category_my' => 'လှုပ်ရှား · ဗီဒီယို', 'logo' => $devIcon.'/aftereffects/aftereffects-original.svg', 'url' => 'https://www.adobe.com/products/aftereffects.html'],
            ['name_en' => 'Blender', 'name_my' => 'Blender', 'category_en' => '3D · Rendering', 'category_my' => '၃D · ရင်ဒါ', 'logo' => $devIcon.'/blender/blender-original.svg', 'url' => 'https://www.blender.org/'],
            ['name_en' => 'Sketch', 'name_my' => 'Sketch', 'category_en' => 'UI · macOS', 'category_my' => 'UI · macOS', 'logo' => $devIcon.'/sketch/sketch-original.svg', 'url' => 'https://www.sketch.com/'],
        ];

        foreach ($stack as $i => $row) {
            DesignTool::query()->create([
                'name_en' => $row['name_en'],
                'name_my' => $row['name_my'],
                'category_en' => $row['category_en'],
                'category_my' => $row['category_my'],
                'logo_path' => $row['logo'],
                'website_url' => $row['url'],
                'sort_order' => $i,
                'is_published' => true,
            ]);
        }
    }
}
