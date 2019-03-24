# Game 02

## Context

A service named YOLO synchronously calls an API named WTF. WTF tends to be very unstable, having latency peaks every now and then that end in response timeouts. If too many timeouts pile up, YOLO's servers may overload and suddenly go down.

## Constraints

- YOLO only waits up to 30 seconds for each call made to WTF.
- YOLO's server has a limited capacity of 10 simultaneous requests.
- YOLO has at least 5 requests per second.
- YOLO is using the best server in the market.
- YOLO needs to make synchronous calls to WTF in each request.

## Challenge

You're required to design an architecture using design patterns that allow YOLO to find out when WTF is having trouble processing requests. Ideally, this architecture should let YOLO know when to stop issuing calls to WTF until WTF is available again.

Be sure to answer this question by outlining the concepts used to tackle the problem, as well as all meaningful interactions between the architecture's components. No programming is required!

##Solución

- Para concer la disponibilidad de WTF desde YOLO se lanza un PING, se analiza la respuesta del mismo para decidir si las solicitudes se seguirán enviando.
- Se tiene un gestor de colas el cual encolará las solcitudes cuando el tiempo de respuesta de WFT sea mayor a 20 segundos (no llegar al límite del tiempo de solicitud para evitar que YOLO se caiga). 
![Cat](https://github.com/jssmy/challenge/blob/master/game-02/arquitectura.png)