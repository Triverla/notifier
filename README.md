## HTTP Notification System

This application accept urls as payload to subscribe to topics on a server and when messages are published to those topics, there are received on those urls.

##Installation
<ol>
<li>Clone repo to your local machine using <code>git clone https://github.com/Triverla/notifier.git</code> </li>
<li>Run <code>composer install from your terminal</code></li>
<li>Run <code>cp .env.example .env</code> to create .env</li>
<li>Configure your database in the .env and run <code>php artisan migrate</code> to migrate database tables</li>
<li>Run <code>php artisan serve</code> to start server</li>
</ol>

## Endpoints
<b>Subscribe to Topic</b>
```markdown
{{URL}}/subscribe/{topic}
```

<b>Request Body</b>
```json
{
    "url":"http://localhost:9000/test1"
}
```

<b>Publish message to topic</b>
```markdown
{{URL}}/publish/{topic}
```

<b>Request Body</b>
```json
{
    "body": {
        "message": "hello"
    }
}
```


## Technology Used
This project was built with PHP(Laravel) and Mysql.

## Tests
Tests were written using PHPUnit.
Run tests using

```markdown
php artisan test
```
