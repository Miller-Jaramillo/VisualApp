# VisualApp - Sistema de Análisis de Datos de Accidentes

VisualApp es una herramienta avanzada para el análisis estadístico de accidentes, diseñada para ayudar a organizaciones y entidades gubernamentales a entender las dinámicas y causas de los accidentes en áreas urbanas y rurales. Utiliza un conjunto de gráficas interactivas y análisis detallados para proporcionar insights valiosos que pueden ser utilizados para mejorar la seguridad vial.

![Ejemplo de Imagen](https://raw.githubusercontent.com/Miller-Jaramillo/v44/main/public/images/visualapp-1.png)
![Ejemplo de Imagen](https://raw.githubusercontent.com/Miller-Jaramillo/v44/main/public/images/visualapp3.png)


## Características

- **Análisis Interactivo:** VisualApp permite a los usuarios explorar datos de accidentes a través de diversas visualizaciones, como gráficos de burbujas, barras apiladas, y más.
- **Filtros por Fecha:** Los usuarios pueden seleccionar rangos de fechas específicos para focalizar los análisis en períodos de tiempo concretos.
- **Reportes Detallados:** El sistema genera análisis detallados sobre las tendencias de accidentes, tipos de víctimas, y otros aspectos cruciales.

## Tecnologías Utilizadas

- **Laravel:** Framework backend para la construcción de la aplicación.
- **Livewire:** Facilita la creación de interfaces dinámicas sin salir del marco de Laravel.
- **Tailwind CSS:** Utilizado para el diseño responsive y estilizado de la aplicación.
- **Alpine.js:** Proporciona la reactividad necesaria para las funciones del lado del cliente.

## Requisitos del Sistema

- PHP = 8.1
- Composer = 2.7.1
- Node = 20.11.0
- NPM  
- Servidor MySQL o equivalente para la base de datos

## Instalación

1. **Clonar el Repositorio:**
   ```
   git clone https://github.com/tu-usuario/visualapp.git
   cd visualapp
   ```

2. **Instalar Dependencias:**
   ```
   composer install
   npm install
   ```

3. **Configuración del Entorno:**
   Copia el archivo `.env.example` a `.env` y modifica las variables de entorno según sea necesario, incluyendo las credenciales de la base de datos.

4. **Generar Clave de Aplicación:**
   ```
   php artisan key:generate
   ```

5. **Migraciones y Semillas:**
   ```
   php artisan migrate
   php artisan db:seed
   ```

6. **Ejecutar el Servidor:**
   ```
   php artisan serve
   ```

## En línea

Este proyecto está disponible en línea y puede ser accedido en [VisualApp Online](http://visualapp.online).

## Uso

### Cargar Datos

Para cargar un archivo Excel con datos de accidentes, asegúrate de que sigue el formato especificado en la sección "Carga de Archivos" de este documento. Accede a la sección de carga en la interfaz de usuario y sigue las instrucciones para subir el archivo.

### Visualización y Análisis

Explora las diferentes visualizaciones disponibles en el menú de navegación. Puedes seleccionar filtros específicos para ajustar los datos mostrados en las gráficas y obtener los análisis deseados.

## Contribuir

Los pull requests son bienvenidos. Para cambios importantes, por favor abre un issue primero para discutir qué te gustaría cambiar.

## Licencia

Este proyecto está bajo la Licencia MIT - ver el archivo [LICENSE.md](LICENSE) para detalles.
