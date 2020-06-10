# ymltoanno
### Symfony Routing Yml to Annotation Converter

it is very easy to convert Yml routing to Annotation using my code.

1: First run `composer install`.

2: Just put all your controllers in the `res/controllers`.
Warning: Don't touch newControllers because you will receive your new controllers with annotation there.

3: Then copy `routing` folder from `Resources/config` and also copy `routing.yml`. don't forget `routing.yml` this code converts all routes and the files mentioned in the routing.yml only.

4: Then just run your `index.php` and you will get all routings converted to annotation in `newControllers` folder. Ignore the warning and just check the folder.

5: Before pasting the new controllers into you project change file permistions of the controllers to 777
if You are using linux you can use `sudo chmod -R 777 path/to/newControllers`. 
`options, expose` not yet supported

6: You may also need to include `use Symfony\Component\Routing\Annotation\Route;` at the top of controller

# Customization
If your bundle name is not AppBundle then open index.php and go to line `48` and `100` and change AppBundle to your bundle name
