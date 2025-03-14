# ProyectoIAW
## Índice
### 1 Descripción
### 2 Estructura del proyecto
### 3 Modelo utilizado
### 4 Conclusión


### 1 Descripción

El proyecto que vamos a desarrollar es una aplicación web, utilizando el modelo MVC para facilitar la estructura de esta, el MVC es un modelo en el que se usan controladores, vistas y modelos sobre los datos que tu quieras utilizar para tu aplicación.

### 2 Estructura del proyecto

La estructura a seguir en el proyecto seria la siguiente:

![image](https://github.com/user-attachments/assets/a672b7ea-256f-4d25-ac1e-47d6b8fc2ef8)

En la carpeta de assets estaran las posibles imagenes que quieras utilizar para el proyecto, dispondremos también de una base de datos, en la que guardaremos en nuestro caso los datos de los productos que dispondremos en nuestra aplicación web y ademas de los usuarios y los administradores que pertenecen a esta.Como observamos en la imagen, usaremos los controladores para facilitar la funcionalidad, en los modelos tendremos los productos y usuarios que dispondremos, en ellos crearemos una clase para cada uno y aplicaremos un constructor y varias funciones publicas,y en las vistas como su nombre indica tendremos todo lo que podremos visualizar en nuestra aplicación web, asi como por ejemplo en ella tendremos un header y un footer.

### 3 Modelo utilizado

#### Modelo

Representa los datos y la lógica de negocio de la aplicación
Gestiona el acceso a la información y su manipulación
Es independiente de la interfaz de usuario
Notifica a la Vista cuando hay cambios en los datos

#### Vista

Presenta la información al usuario
Muestra los datos proporcionados por el Modelo
Envía las acciones del usuario al Controlador
Se encarga únicamente de la visualización

#### Controlador

Actúa como intermediario entre el Modelo y la Vista
Procesa las solicitudes del usuario
Manipula el Modelo según sea necesario
Selecciona la Vista adecuada para presentar la respuesta

#### Beneficios

**Separación de responsabilidades:** Cada componente tiene un propósito específico

**Reutilización de código:** Los componentes pueden usarse en diferentes partes de la aplicación

**Mantenibilidad:** Los cambios en un componente tienen un impacto mínimo en los demás

**Desarrollo paralelo:** Diferentes desarrolladores pueden trabajar en distintos componentes simultáneamente

**Facilita las pruebas:** Cada componente puede probarse de forma aislada

### 4 Conclusión

La implementación del modelo MVC en nuestra aplicación web ha sido altamente beneficiosa. Esta arquitectura nos permitió:

-Separar responsabilidades entre datos, interfaz y lógica de control

-Facilitar el mantenimiento y las actualizaciones del sistema

-Adaptarnos ágilmente a los cambios en el mercado informático





