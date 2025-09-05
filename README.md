# Symfony AI Bundle

- [Documentación](https://github.com/symfony/ai-platform/blob/main/doc/index.rst)

## Instalación

Crear .env.local con la siguiente configuración:

~~~
OPENAI_API_KEY=foo
~~~


### Comandos


- Comunicación con OpenAI

```bash
php bin/console app:ai:ask "Color de la bandera de Colombia"
```

- Embedding

```bash
php bin/console app:ai:embedding-ask "Quiero aprender inteligencia artificial"
```
