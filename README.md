# ymltoanno
### Symfony Routing Yml to Annotation Converter

It is very easy to convert Yml routing to Annotation using my code.
Just put all your controllers in the `res/controllers`. Don't touch newControllers. You will receive your new controllers with annotation there.
Then copy `routing` folder from `Resources/config` and also copy `routing.yml`. don't forget `routing.yml` this code converts all routes and the files mentioned in the routing.yml only.

Then just run your `index.php` and you will get all routings converted to annotation in `newControllers` folder.
`options, expose` not yet supported

