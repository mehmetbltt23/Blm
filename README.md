# Blm File Reader &amp; Blm File Creator Package


### Docker Build and Create Container
##### Before
Remove Comment ``Dockerfile:21``
Remove Comment ``Dockerfile:22``
##### After
``docker image build -t blm .`` \
``docker container run -d --name blm-package blm``
#### Compose
``docker-compose up -d --build ``

