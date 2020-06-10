# ymltoanno
### Symfony Routing Yml to Annotation Converter

it is very easy to convert Yml routing to Annotation using my code.
1: Just put all your controllers in the `res/controllers`.
Warning: Don't touch newControllers because you will receive your new controllers with annotation there.
2: Then copy `routing` folder from `Resources/config` and also copy `routing.yml`. don't forget `routing.yml` this code converts all routes and the files mentioned in the routing.yml only.

3: Then just run your `index.php` and you will get all routings converted to annotation in `newControllers` folder.
`options, expose` not yet supported

# Customization
If your bundle name is not AppBundle then open index.php and go to line `48` and `100` and change AppBundle to your bundle name
