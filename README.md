# Co10 Escape Statistics service

This statistics service is a draft of a service that tracks mission/match statistics for the Escape mission for ArmA 3.
The mission itself can be found in https://github.com/NeoArmageddon/co10_Escape.

## Components

This service consists of two components, a backend and a frontend component.

### Backend

The backend/api component is a small and lightweight API written in PHP with the use of the Lumen framework.
It provides the mission an endpoint to report statistics for a match, as well as endpoints to query for a statistics.

### Frontend

The frontend is a web-application written in TypeScript using Angular.
It provides an informational start page as well as some statistics for recent and overall matches tracked by the API component.

## Running

Both, the Backend and Frontend are build having a containerized operation in mind.
Therefore, both components provide a production-ready Dockerfile, which can be used to build a deployable image.
There's also an example `docker-compose.yml` to start the application stack locally or in production.
The latter is, however, not recommended, as it uses a single-node MySQL database, which data is not saved apart from inside the container.

## Starting development version

To develop new features or bugfixes, you may start the app by your own or use the `docker-compose.yml` file within the ./dev/ folder.
To start the frontend, simply issue a `npm start` inside of the ./frontend/ folder.

