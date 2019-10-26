# Running the application

1. Start the containers
    ```bash
    $ docker-compose up -d webserver
    ```

# View example totals

1. In console execute:
    ```bash
    $ curl -X GET http://localhost:8000/example/one/
    ```

2. In console execute:
    ```bash
    $ curl -X GET http://localhost:8000/example/two/
    ```

3. In console execute:
    ```bash
    $ curl -X GET http://localhost:8000/example/three/
    ```
