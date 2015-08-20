# Laravel models MODX

Laravel 5 Eloquent Database models for connecting to ModX PDOx style database. We used this models to fetch page data from the *MODX CMS* database. This includes:

  - Content model to retrieve modx_site_content 
  - Page model to retrieve data based on Template ID

> Just copy all this models in your /app/ directory of your laravel installation

If you want to add new models and retrieve the data based on the modx_template, copy one of the examples (ex. Books.php) and just change the MODX_TEMPLATE constant on top of the model.

    class Books extends PageModel{
        const MODX_TEMPLATE = 13; // id reference of the MODX template
    }
    
    //now you can build queries in your controller; example:
    
    $book = Books::where('alias','=','/example-book')
                    ->with('templateVars');
                    ->published()
                    ->sortPublished()
                    ->get();
    //Get your template variables from the templateVariables collection;                    
    $book->templateVariables->get('KeyOfTemplateVar');
    
