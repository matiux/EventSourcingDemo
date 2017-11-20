Info
========================

###RabbitMq
##### Per vedere le code attive e alcune proprietà:
```
rabbitmqctl list_queues name messages_ready messages_unacknowledged durable
```
##### Stop reset e restart
```
rabbitmqctl stop_app
rabbitmqctl reset
rabbitmqctl start_app
```

### Fix Sf permission in PHP container:

Da dentro al container php:

```
HTTPDUSER=$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1)
setfacl -dR -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var
setfacl -R -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var
```
