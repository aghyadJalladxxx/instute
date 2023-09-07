## About Project

this project follows the structure of  a microservice represeting the application users:

it handles the basic authentication between users and app,
and provides methods to authenticate the microservice with other microservices

Overview:
    - each microservice should use the exact same secret key stored in the env file, therefore any user who is authenticated with this service, should be able to interact with any other microservice
    - the token also includes additional info, such as : the user id, and the user role, and it can extend to include any other informations to be used by other microservices.



Database:
    - we used microdatabases, each microservices has its won database, and can relate with other databases based on the info provided by the token
    - updates:
         - to make sure that the databases are synced with each other, the best way to use a message broker like rabbitmq, or apache kafka, but due to lake of time and resources, I hda to implement 
            a "web-hook" based solution, you can see an example of the "unfinished implementation" in the UserDeleteHook class.
      
   - use case example: 
                    - user the pwoer of laravelr observers (observe database changes on the model level), we can check if an operation is  a user delete, 
                        when that happens , we can call any action we want, in this case it is calling hooks on other microservices to delete the related records based on the posted data.
                        note that microservices are authenticated between each other based on a custom built jwt using a different jwtlibrary that is not depply integrated within laravel auth system,
                        because this library can be used despite the overlaying framework or language, so the code is implemented the same way on any platofrm or language
