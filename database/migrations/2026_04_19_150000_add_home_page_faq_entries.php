<?php

use App\Models\Faq;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @return array<int, array<string, string>>
     */
    private function additionalFaqs(): array
    {
        return [
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
    }

    public function up(): void
    {
        if (! Schema::hasTable('faqs')) {
            return;
        }

        $next = (int) Faq::query()->max('sort_order') + 1;

        foreach ($this->additionalFaqs() as $row) {
            $created = Faq::query()->firstOrCreate(
                ['question_en' => $row['question_en']],
                [
                    'question_my' => $row['question_my'],
                    'answer_en' => $row['answer_en'],
                    'answer_my' => $row['answer_my'],
                    'sort_order' => $next,
                    'is_published' => true,
                ]
            );

            if ($created->wasRecentlyCreated) {
                $next++;
            }
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('faqs')) {
            return;
        }

        foreach ($this->additionalFaqs() as $row) {
            Faq::query()->where('question_en', $row['question_en'])->delete();
        }
    }
};
