 ## Button group generator. 
 
The button group package provides a fluent interface to build Button Groups with bootstrap layout and custom group items.
 ### Examples
 ```
 {!!
 ButtonGroup::new()
 ->id(123) //Common data id by default will be generated data-id attribute for all <a> tags
 ->add('create', ['class'=>'my class', ... (other attributes)]) //generate button with name create
 ->add('delete');
 !!}
```
outputs:
```
<div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Manage 
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li class="list-item"><a href="#" data-action="create" data-id="123">New</a></li>
        <li class="list-item"><a href="#" data-action="delete" data-id="123">Delete</a></li>
    </ul>
</div>
```
Default button javascript actions (CRUD):
- create, create new resource
- read, move to resource url
- update, inline update the data row
- delete, delete the row and remove the link

Different usage samples:
```
 ButtonGroup::new('create');
 ButtonGroup::new('create', 'read', 'update', 'delete')->id(123);

ButtonGroup::new('create')->
->add('edit', ['data-url'=>'posts/edit/'.$post->id, 'data->id'=>123]);
```
 ## Javascript 
Package use Blade  @stack('script') directive in main layout to output package javascript. 
When custom button is created (outside of package build-in CRUD actions), the buttongroup.actions js object should be extended with new button name.
For example, you create new button  with name 'custom':   
```$php
//Laravel view
....
//when you need button group
ButtonGroup::new()->
->add('custom', ['data-custom'=>'your custom data', 'data->id'=>123]);
...
//at the end of view
@push('scripts')
<script>
    jQuery(document).ready(function(obj, button) {
        
        //'custom' is buttongroup.actions action
        buttongroup.actions.custom = function (obj, button) {
        var id = $(button).data('id'); // or obj.recordId 
        //when obj - is buttongroup object
        // button is reference to the button clicked, for example to get 'data-custom' attribute you will need
        // $(button).data('custom')
        };

</script>
@endpush
```
## Translations and names. 

Button names and translations are stored in package/resources/lang folder by language(language got from Laravel environment locale).
By default when action   name is not mentioned in languages, any new action is represented in Button dropdown with the same, capitalized name. 
