# Laravel models MODX

Laravel 5 Eloquent Database models for connecting to ModX PDOx style database. We used this models to fetch page data from the *MODX CMS* database. This includes:

  - Content model to retrieve modx_site_content 
  - Page model to retrieve data based on Template ID

If you want to add new models and retrieve the data based on the modx_template, copy one of the examples (ex. Books.php) and just change the MODX_TEMPLATE constant on top of the model.
    use Rvanmarkus/Modxmodels/PageModel

    class Books extends PageModel{
        const MODX_TEMPLATE_ID = 3; // id reference of the MODX (book) template
    }
    
    //now you can build queries in your controller; example:
   
    $book = Books::where('alias','=','/example-book')
                    ->with('templateVars');
                    ->published()
                    ->sortPublished()
                    ->get();

    //Get your template variables from the templateVariables collection;                    
    $book->templateVariables->get('NameOfTemplateVariables');


> The ModxContentModel will query all the page data (all columns defined in modx_site_content table), you can make new models with other tables if you want. Or use just MODX pages with different templates IDs.

## Template variables
 You can eager load template variables by adding the 'TemplateVariables' relation (see Laravel [Eloquent Docs](http://laravel.com/docs/eloquent) for more information)
    
    $Books::with('templateVariables')
    
The model casts automatically the values of your template variables to PHP types. The cast will automatically been done for the following template variables with the types:
  - Date
  - Text
  - checkbox (multiple values)
  - MIGX data

example: 

    $book->templateVariables->get('DateTemplateVariable') 
    // returns Carbon DateTime Object value
        
    $book->templateVariables->get('MIGXTemplateVariable') 
    // returns PHP Object value
    
    $book->templateVariables->get('CheckboxTemplateVariable') 
    // returns PHP Array value
    
    $book->templateVariables->get('TextTemplateVariable') 
    // returns string value
    

 
##Install
add this to your composer.json : 
    
    {
        "require": {
            "rvanmarkus/modx-laravel-models": "dev-master"
        },
        "repositories": [
            {
                "type": "vcs",
                "url":  "git@github.com:rvanmarkus/modx-laravel-models.git"
            }
        ]
    }

Start using your models with MODX data extending the Rvanmarkus/Modxmodels/ModxContentModel class! 

