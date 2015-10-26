# Laravel models MODX

[Laravel](http://laravel.com) 5 Eloquent Database models for connecting to [MODX](http://modx.com) PDOx style database. 
We've used this models to fetch page data from MODX (mysql) database to our Laravel Application. Almost all of our models extends from this ModxContentModels.

This packages has the following models:

  - ModxContentModel to retrieve global page content, and retrieve the related TemplateVariables 
  - ModxPageModel same as ModxContentModel but can be used to constrain the model to a specific type page ( based on template id)  

> The ModxContentModel will query all the MODX standard page content data (all columns like content, title, alias etc defined in modx_site_content table).
(don't forget to set the 'use Rvanmarkus/Modxmodels/ModxContentModel' on top of your controller)

example:
 
    //query just the page model
    $content = ModxContentModel::where('alias','=','/about-us')->get();  
   
  

> But you can also make specific models for your domain model and specify the model by a template ID(ex. App/Books.php):

    use Rvanmarkus/Modxmodels/PageModel

    class Books extends PageModel{
        const MODX_TEMPLATE_ID = 3; // id reference of the MODX (book) template (can be founded in MODX / or database)
    }
    
> now you can build queries in your controller like this:
   
    $book = Books::where('alias','=','/example-book')
                    ->with('templateVariables');
                    ->published()
                    ->sortPublished()
                    ->get();

    //Get your template variables from the templateVariables collection;                    
    $book->templateVariables->get('NameOfTemplateVariables');
    

## Template variables
 You can eager load template variables by adding the 'TemplateVariables' relation (see Laravel [Eloquent Docs](http://laravel.com/docs/eloquent) for more information)

    use Rvanmarkus/Modxmodels/ModxContentModel
            
    //query content models where alias is'/about-us' and load all related template variables  
    $book = Books::with('templateVariables')
                ->where('alias','=','/john-doe-the-book')
                ->published()
                ->firstOrFail();
               
    //for example we have a checkbox TV in MODX called 'Genres'
     
    $tv = $book->templateVariables->get('Genres'); //ex. ['Roman','Science Fiction'] returns a array of selected checkbox TV values


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

