<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Template;

class AiTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $template = [
            [
                'template_name'=>'name',
                'prompt'=>"please suggest subscription plan name for this  :  ##title##:  for my business",
                'module'=>'plan',
                'field_json'=>'{"field":[{"label":"What is your plan title?","placeholder":"e.g. Pro Resller,Exclusive Access","field_type":"text_box","field_name":"title"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'description',
                'prompt'=>"please suggest subscription plan description for this  :  ##description##  for my business",
                'module'=>'plan',
                'field_json'=>'{"field":[{"label":"What is your plan about?","placeholder":"e.g. Describe your plan details ","field_type":"textarea","field_name":"description"}]}',
                'is_tone'=>'1',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'name',
                'prompt'=>"give 10 catchy only name of Offer or discount Coupon for : ##keywords##",
                'module'=>'coupon',
                'field_json'=>'{"field":[{"label":"Seed words","placeholder":"e.g.coupon will provide you with a discount on your selected plan","field_type":"text_box","field_name":"keywords"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'meta_keyword',
                'prompt'=>"Please generate SEO meta title for my business, ##name##, which specializes in ##specializes##.",
                'module'=>'seo',
                'field_json'=>'{"field":[{"label":"Business Name","placeholder":"e.g. your business or your website name","field_type":"text_box","field_name":"name"},{"label":"Specializes in what?","placeholder":"e.g.your web or business specialities","field_type":"text_box","field_name":"specializes"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'meta_description',
                'prompt'=>"Write SEO meta description for:\n\n ##description## \n\nWebsite or Business name is:\n ##title## \n\nSeed words:\n ##keywords## \n\n",
                'module'=>'seo',
                'field_json'=>'{"field":[{"label":"Business Name","placeholder":"e.g. Amazon, Google","field_type":"text_box","field_name":"title"},{"label":"Business Description","placeholder":"e.g. Describe what your website or business do","field_type":"textarea","field_name":"description"},{"label":"Keywords","placeholder":"e.g.  cloud services, databases","field_type":"text_box","field_name":"keywords"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],[
                'template_name'=>'cookie_title',
                'prompt'=>"please suggest me cookie title for this ##description## website which i can use in my website cookie",
                'module'=>'cookie',
                'field_json'=>'{"field":[{"label":"Website name or info","placeholder":"e.g. example website ","field_type":"textarea","field_name":"title"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],[
                'template_name'=>'cookie_description',
                'prompt'=>"please suggest me  Cookie description for this cookie title ##title##  which i can use in my website cookie",
                'module'=>'cookie',
                'field_json'=>'{"field":[{"label":"Cookie Title ","placeholder":"e.g. example website ","field_type":"text_box","field_name":"title"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'strictly_cookie_title',
                'prompt'=>"please suggest me only Strictly Cookie Title for this ##description## website which i can use in my website cookie",
                'module'=>'cookie',
                'field_json'=>'{"field":[{"label":"Website name or info","placeholder":"e.g. example website ","field_type":"textarea","field_name":"title"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'strictly_cookie_description',
                'prompt'=>"please suggest me Strictly Cookie description for this Strictly cookie title ##title##  which i can use in my website cookie",
                'module'=>'cookie',
                'field_json'=>'{"field":[{"label":"Strictly Cookie Title ","placeholder":"e.g. example website ","field_type":"text_box","field_name":"title"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'more_information_description',
                'prompt'=>"I need assistance in crafting compelling content for my ##web_name## website's 'Contact Us' page of my website. The page should provide relevant information to users, encourage them to reach out for inquiries, support, and feedback, and reflect the unique value proposition of my business.",
                'module'=>'cookie',
                'field_json'=>'{"field":[{"label":"Websit Name","placeholder":"e.g. example website ","field_type":"text_box","field_name":"web_name"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'content',
                'prompt'=>"generate email template for ##type##",
                'module'=>'email template',
                'field_json'=>'{"field":[{"label":"Email Type","placeholder":"e.g. new user,new client","field_type":"text_box","field_name":"type"}]}',
                'is_tone'=>'1',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'note',
                'prompt'=>"Generate an appointment short message for ##status## status on behalf of my ##name##.",
                'module'=>'Add Note on appointment',
                'field_json'=>'{"field":[{"label":"Business Name","placeholder":"e.g. graphics design ","field_type":"text_box","field_name":"name"},{"label":"Appointment Status","placeholder":"e.g. pending,complete","field_type":"text_box","field_name":"status"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'note',
                'prompt'=>"Generate an contact short message for ##status## status on behalf of my ##name##.",
                'module'=>'Add Note on contact',
                'field_json'=>'{"field":[{"label":"Business Name","placeholder":"e.g. graphics design ","field_type":"text_box","field_name":"name"},{"label":" Status","placeholder":"e.g. pending,complete","field_type":"text_box","field_name":"status"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'business_title',
                'prompt'=>"Generate an innovative and memorable business name for a startup that ##description##. The businees focuses on ##description##. The name should reflect the businees's commitment to ##commitment##",
                'module'=>'create business',
                'field_json'=>'{"field":[{"label":"Business Agenda","placeholder":"e.g.focus on laravel web development","field_type":"textarea","field_name":"description"},{"label":"Business Commitment","placeholder":"e.g Laravel is considered the standard in web development, taking it to the top note.","field_type":"textarea","field_name":"commitment"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'title',
                'prompt'=>"Generate an innovative and memorable business name for a startup that ##description##. The businees focuses on ##description##. The name should reflect the businees's commitment to ##commitment##",
                'module'=>'edit business',
                'field_json'=>'{"field":[{"label":"Business Agenda","placeholder":"e.g.focus on laravel web development","field_type":"textarea","field_name":"description"},{"label":"Business Commitment","placeholder":"e.g Laravel is considered the standard in web development, taking it to the top note.","field_type":"textarea","field_name":"commitment"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'designation',
                'prompt'=>"Create unique and fitting business designations for the different roles within '##type##' a  business that offers ##offers##. The designations should reflect the business's commitment ##commitment## in the industry. Consider job titles that capture the essence of various roles, such as ##roles## etc.",
                'module'=>'edit business',
                'field_json'=>'{"field":[{"label":"Business Field/Type","placeholder":"e.g.ecommmerce","field_type":"text_box","field_name":"type"},{"label":"What your business offer?","placeholder":"e.g.baby products","field_type":"text_box","field_name":"offers"},{"label":"Business Commitment","placeholder":"e.g Provide best products and after sale service.","field_type":"textarea","field_name":"commitment"},{"label":"Roles","placeholder":"e.g leadership,customer care.","field_type":"text_box","field_name":"roles"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'sub_title',
                'prompt'=>"Generate compelling subtitles for ##name##, highlighting their unique offering ##sevices##, values, and benefits.",
                'module'=>'edit business',
                'field_json'=>'{"field":[{"label":"Business Name","placeholder":"Rajodiya Infotech","field_type":"text_box","field_name":"name"},{"label":"Providing services","placeholder":"provide best web base development","field_type":"textarea","field_name":"sevices"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'description',
                'prompt'=>"Imagine you are launching a new business called ##title## it related to ##description## Write a compelling description that showcases the unique features, services, and values of your business. Highlight how [business name] stands out from competitors and why customers should choose your business for their needs.",
                'module'=>'edit business',
                'field_json'=>'{"field":[{"label":"Business Name","placeholder":"Business Name","field_type":"text_box","field_name":"title"},{"label":"Business Field","placeholder":"Business field","field_type":"textarea","field_name":"description"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'service_title',
                'prompt'=>"Generate a list of service names that can be provided by a ##designation##. Consider the expertise and responsibilities associated with this designation and brainstorm a range of services that align with their role. Think about the specific tasks, deliverables, or solutions that this designation would typically provide to clients or customers. Be creative and comprehensive in generating a diverse list of service names that capture the breadth of offerings associated with this designation.",
                'module'=>'service business',
                'field_json'=>'{"field":[{"label":"Designation","placeholder":"e.g.Bankend developer","field_type":"text_box","field_name":"designation"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'service_description',
                'prompt'=>"Develop a detailed service description for the ##title##. Describe the key features, benefits, and deliverables associated with this service. Consider the specific needs it addresses, the unique value it offers, and the outcomes clients can expect. Provide clear and concise information that highlights the expertise and capabilities required to deliver this service effectively. Use this prompt to craft a compelling service description that communicates the value proposition and encourages potential clients to engage with the service.",
                'module'=>'service business',
                'field_json'=>'{"field":[{"label":"Service title","placeholder":"e.g.Bankend development","field_type":"text_box","field_name":"title"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
            [
                'template_name'=>'testimonial_description',
                'prompt'=>"Imagine you are a satisfied customer of your own business. Write a testimonial expressing your positive experience and satisfaction with the ##description## . Highlight specific aspects that make your business stand out, such as ##highlight##, or the positive impact your business has had on your life or work. Make sure to convey your genuine enthusiasm and recommendation for others to experience the same level of satisfaction.",
                'module'=>'testimonial',
                'field_json'=>'{"field":[{"label":"Testimonial Description","placeholder":"e.g.products or services provided","field_type":"textarea","field_name":"description"},{"label":"Highlight Points","placeholder":"e.g exceptional customer service, high-quality offerings, unique features","field_type":"textarea","field_name":"highlight"}]}',
                'is_tone'=>'0',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],

        ];
        Template::insert($template);
    }
}
