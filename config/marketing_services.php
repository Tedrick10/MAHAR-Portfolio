<?php

declare(strict_types=1);

$locale = static fn (string $en, string $my): array => ['en' => $en, 'my' => $my];

return [
    'facebook' => [
        'branding' => [
            [
                'tier' => $locale('STANDARD', 'စတန်ဒတ်'),
                'option' => $locale('Option — 1', 'ရွေးချယ်မှု — ၁'),
                'revision' => $locale('Revision — 1', 'ပြင်ဆင်မှု — ၁'),
                'items' => [
                    $locale('FB Profile', 'FB Profile'),
                    $locale('Cover Photo', 'Cover Photo'),
                    $locale('Business Card design', 'လုပ်ငန်းကတ် ဒီဇိုင်'),
                ],
            ],
            [
                'tier' => $locale('PREMIUM', 'ပရီမီယံ'),
                'option' => $locale('Option — 2', 'ရွေးချယ်မှု — ၂'),
                'revision' => $locale('Revision — 2', 'ပြင်ဆင်မှု — ၂'),
                'items' => [
                    $locale('FB Profile', 'FB Profile'),
                    $locale('Cover Photo', 'Cover Photo'),
                    $locale('Business Card design', 'လုပ်ငန်းကတ် ဒီဇိုင်'),
                    $locale('Letter Head design', 'လက်မှတ် ခေါင်းစီး ဒီဇိုင်'),
                    $locale('Brand Pattern', 'ဘရန်း ပက်တန်း'),
                    $locale('Logo Grid', 'လိုဂို ဂရစ်'),
                    $locale('Logo Guide', 'လိုဂို လမ်းညွှန်'),
                ],
            ],
            [
                'tier' => $locale('GOLD', 'ဂိုလ်'),
                'option' => $locale('Option — 1', 'ရွေးချယ်မှု — ၁'),
                'revision' => $locale('Revision — 2', 'ပြင်ဆင်မှု — ၂'),
                'items' => [
                    $locale('FB Profile', 'FB Profile'),
                    $locale('Cover Photo', 'Cover Photo'),
                    $locale('Business Card design', 'လုပ်ငန်းကတ် ဒီဇိုင်'),
                    $locale('Letter Head design', 'လက်မှတ် ခေါင်းစီး ဒီဇိုင်'),
                    $locale('Brand Pattern', 'ဘရန်း ပက်တန်း'),
                    $locale('Logo Grid', 'လိုဂို ဂရစ်'),
                ],
            ],
        ],
        'monthly' => [
            [
                'name' => $locale('Basic', 'အခြေခံ'),
                'price' => '400,000',
                'currency' => 'MMK',
                'features' => [
                    $locale('5 Professional Posts / Month', 'ပရော်ဖက်ရှင်နယ် ပို့စ်များ ၅ ခု / လ'),
                    $locale('Monthly Marketing Plan & Strategy', 'လစဉ် မာကတ်တင်း အစီအစဉ် နှင့် မဟာဗျူဟာ'),
                    $locale('Content Calendar', 'အကြောင်းအရာ ပြက္ခဒိန်'),
                    $locale('Media Buying Support (FOC)', 'မီဒီယာ ဝယ်ယူမှု ပံ့ပိုးမှု (အခမဲ့)'),
                    $locale('Standard Reporting', 'စတန်ဒတ် အစီရင်ခံစာ'),
                ],
            ],
            [
                'name' => $locale('Silver', 'ငွေရောင်'),
                'price' => '800,000',
                'currency' => 'Ks',
                'features' => [
                    $locale('10 Professional Posts / Month', 'ပရော်ဖက်ရှင်နယ် ပို့စ်များ ၁၀ ခု / လ'),
                    $locale('Marketing Plan & Strategy', 'မာကတ်တင်း အစီအစဉ် နှင့် မဟာဗျူဟာ'),
                    $locale('Content Calendar', 'အကြောင်းအရာ ပြက္ခဒိန်'),
                    $locale('1 Seasonal Post (FOC)', 'ရာသီအလိုက် ပို့စ် ၁ ခု (အခမဲ့)'),
                    $locale('Initial Comment Reply', 'ပထမဆုံး ကွန်မန့် ပြန်ကြားမှု'),
                    $locale('2 Competitors Analysis', 'ပြိုင်ဘက် ၂ ခု ခွဲခြမ်းစိတ်ဖြာမှု'),
                    $locale('Advanced Media Buying (FOC) — Custom Audience Building', 'အဆင့်မြင့် မီဒီယာ ဝယ်ယူမှု (အခမဲ့) — ပရိသတ် တည်ဆောက်မှု'),
                    $locale('Standard Reporting', 'စတန်ဒတ် အစီရင်ခံစာ'),
                ],
            ],
            [
                'name' => $locale('Gold', 'ရွှေရောင်'),
                'price' => '1,200,000',
                'currency' => 'MMK',
                'features' => [
                    $locale('15 Professional Posts / Month (includes 1 motion graphic video)', 'ပရော်ဖက်ရှင်နယ် ပို့စ် ၁၅ ခု / လ (မိုရှင်း ဂရပ်ဖစ် ဗီဒီယို ၁ ခု ပါဝင်)'),
                    $locale('Marketing Plan & Strategy', 'မာကတ်တင်း အစီအစဉ် နှင့် မဟာဗျူဟာ'),
                    $locale('Content Calendar', 'အကြောင်းအရာ ပြက္ခဒိန်'),
                    $locale('2 Seasonal Posts (FOC)', 'ရာသီအလိုက် ပို့စ် ၂ ခု (အခမဲ့)'),
                    $locale('Profile & Cover Photo (FOC)', 'ပရိုဖိုင် နှင့် ကာဗာဓာပုံ (အခမဲ့)'),
                    $locale('Initial Comment Reply', 'ပထမဆုံး ကွန်မန့် ပြန်ကြားမှု'),
                    $locale('5 Competitors Analysis', 'ပြိုင်ဘက် ၅ ခု ခွဲခြမ်းစိတ်ဖြာမှု'),
                    $locale('Advanced Media Buying (FOC) — Custom Audience Building', 'အဆင့်မြင့် မီဒီယာ ဝယ်ယူမှု (အခမဲ့) — ပရိသတ် တည်ဆောက်မှု'),
                    $locale('Standard Reporting', 'စတန်ဒတ် အစီရင်ခံစာ'),
                ],
            ],
        ],
    ],
    'tiktok' => [
        'plan_labels' => [
            $locale('Plan A', 'အစီအစဉ် A'),
            $locale('Plan B', 'အစီအစဉ် B'),
            $locale('Plan C', 'အစီအစဉ် C'),
            $locale('Plan D', 'အစီအစဉ် D'),
        ],
        'rows' => [
            [
                'label' => $locale('Account settings aligned with your business', 'လုပ်ငန်းနှင့်ကိုက်ညီသော အကောင့် ဆက်တင်များ'),
                'cells' => ['yes', 'yes', 'yes', 'yes'],
            ],
            [
                'label' => $locale('Profile photo styling for your brand', 'လုပ်ငန်းပုံရိပ်အတွက် ပရိုဖိုင်ပြင်ဆင်မှု'),
                'cells' => ['yes', 'yes', 'yes', 'yes'],
            ],
            [
                'label' => $locale('Content idea & strategy', 'အကြောင်းအရာ စိတ်ကူးနှင့် မဟာဗျူဟာ'),
                'cells' => ['yes', 'yes', 'yes', 'yes'],
            ],
            [
                'label' => $locale('Engaging script writing', 'ဆွဲဆောင်မှုရှိသော စာသားများ ဖန်တီးမှု'),
                'cells' => ['yes', 'yes', 'yes', 'yes'],
            ],
            [
                'label' => $locale('Video production', 'ဗီဒီယို ရိုက်ကူးမှု'),
                'cells' => [
                    $locale('—', '—'),
                    $locale('Smartphone shoot', 'ဖုန်းဖြင့် ရိုက်ကူး'),
                    $locale('Pro entry camera', 'ပရို ကင်မရာ'),
                    $locale('Pro videographer + camera', 'ပရို ဗီဒီယိုဂရာဖာ + ကင်မရာ'),
                ],
            ],
            [
                'label' => $locale('Professional editing', 'ပရော်ဖက်ရှင်နယ် တည်းဖြတ်မှု'),
                'cells' => [
                    $locale('Yes', 'ရှိ'),
                    $locale('Yes', 'ရှိ'),
                    $locale('Yes', 'ရှိ'),
                    $locale('Pro editor', 'ပရို တည်းဖြတ်သူ'),
                ],
            ],
            [
                'label' => $locale('Talent (on-screen)', 'သရုပ်ဆောင်'),
                'cells' => ['no', 'no', 'yes', 'yes'],
            ],
            [
                'label' => $locale('Hashtag & posting', 'ဟက်ရှ်တက် နှင့် တင်ခြင်း'),
                'cells' => ['yes', 'yes', 'yes', 'yes'],
            ],
            [
                'label' => $locale('Media buying (sales / awareness)', 'ရောင်းအား သို့မဟုတ် သိရှိမှု မြှင့်တင်ရန် မီဒီယာ ဝယ်ယူမှု'),
                'cells' => ['no', 'no', 'no', $locale('$3 / video add-on', 'ဗီဒီယို တစ်ပုဒ်လျှင် $3')],
            ],
            [
                'label' => $locale('Monthly insight report', 'လစဉ် ခွဲခြမ်းစိတ်ဖြာအစီရင်ခံစာ'),
                'cells' => ['no', 'yes', 'yes', 'yes'],
            ],
        ],
        'per_video' => ['80,000', '120,000', '180,000', '250,000'],
        'totals' => ['800,000', '1,200,000', '1,800,000', '2,500,000'],
        'footnote' => $locale(
            'Minimum order: packages start from 10 videos.',
            'အနည်းဆုံး ၁၀ ပုဒ်မှ စတင်လက်ခံသည်။'
        ),
    ],
];
