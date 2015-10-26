# Laravel models MODX

[Laravel](http://laravel.com) 5 Eloquent Database models to interact with [MODX](http://modx.com) database.

> This package helps you building Laravel applications that queries MODX pages/content and template variables. Use all the modern and beautiful features of the Laravel framework and give your users the ease of the MODX CMS.

## Installation

    $ composer require rvanmarkus/modx-laravel-models

Or add this to your composer.json

    "require": {
        "rvanmarkus/modx-laravel-models": "dev-master"
    }

##Getting started

### Using the Rvanmarkus/Modxmodels/ModxContentModel class directly

    use Rvanmarkus/Modxmodels/ModxContentModel
 
    //query just the content model
    $content = ModxContentModel::where('alias','=','/about-us')->get(); //queries directly modx_site_content table => returns title, content, author, etc  
   
 
### Using your own model class that specified a MODX template
 Create a new PHP Class and extend the Rvanmarkus/Modxmodels/PageModel. Create a new template in MODX manager and add the new template ID to the model.  

*(ex. App/Books.php)*
    use Rvanmarkus/Modxmodels/PageModel

    class Books extends PageModel{
        const MODX_TEMPLATE_ID = 3; // id reference of the MODX (book) template (can be founded in MODX manager / or database)
    }
    
    $book = Books::where('alias','=','/example-book')
                    ->with('templateVariables');
                    ->published()
                    ->sortPublished()
                    ->get();

    //Get your template variables from the templateVariables collection;                    
    $book->templateVariables->get('NameOfTemplateVariables');
   
### 3. Using your own model classes and scopes  
If you don't want a model that is specified by a template, create a model that extends the Rvanmarkus/Modxmodels/ModxContentModel class directly without the PageModel class. This class will query all the modx_site_content data by default, according the scopes you add. See the Eloquent documentation for more information.

 
## Template variables
 You can eager load template variables by adding the 'TemplateVariables' relation (see Laravel [Eloquent Docs](http://laravel.com/docs/eloquent) for more information)

    use Rvanmarkus/Modxmodels/ModxContentModel
            
    //query content models where alias is'/about-us' and load all related template variables  
    $book = Books::with('templateVariables')
                ->where('alias','=','/john-doe-the-book')
                ->published()
                ->firstOrFail();
               
    //for example: query the template variable (added in the MODX manager, with input type: *checkbox*) called 'Genres'
     
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
    
