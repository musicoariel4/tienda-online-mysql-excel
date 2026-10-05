# 🛒 Tienda Online — MySQL, PHP y Excel

Proyecto de gestión y análisis de ventas desarrollado con **PHP, MySQL y Excel**, orientado al manejo de información de una tienda online.

El proyecto integra una base de datos MySQL con diferentes módulos PHP para gestionar clientes, productos y ventas, además de herramientas para consultar, analizar y visualizar la información.

## 🎯 Objetivo

Construir una solución sencilla para:

* Administrar clientes.
* Administrar productos.
* Registrar y consultar ventas.
* Consultar información almacenada en MySQL.
* Generar análisis y gráficos de ventas.
* Exportar información para trabajarla en Excel.
* Practicar la integración entre PHP, MySQL y Excel.

## 🛠️ Tecnologías utilizadas

* **PHP**
* **MySQL**
* **HTML5**
* **CSS3**
* **JavaScript**
* **Excel**
* **Git y GitHub**
* **Composer**

## 📁 Estructura del proyecto

```text
tienda-online-mysql-excel/
│
├── html_php/
│   ├── módulos PHP y HTML
│   ├── dashboard_tienda_online/
│   └── login_system/
│
├── sql/
│   └── tienda_online.sql
│
├── excel/
│   ├── DATASET.xlsx
│   └── clientes.xlsx
│
├── documentos/
│   ├── Guía para gráficas
│   └── Guía rápida de Bind
│
└── .gitignore
```

## 🗄️ Base de datos

La base de datos utilizada en el proyecto se denomina:

```text
tienda_online
```

Incluye información relacionada con clientes, productos y ventas.

El script de creación de la base de datos se encuentra en:

```text
sql/tienda_online.sql
```

## 📊 Análisis y visualización

El proyecto incluye diferentes consultas y módulos para analizar información de ventas, entre ellos:

* Ventas por cliente.
* Ventas por producto.
* Ventas diarias.
* Análisis de productos.
* Histograma de productos.
* Análisis de clientes por fechas.
* Alertas relacionadas con el stock.

También se incluyen archivos de Excel utilizados para trabajar con los datos.

## 🌐 Módulos PHP

Entre las funcionalidades desarrolladas se encuentran:

* CRUD de clientes.
* CRUD de productos.
* Registro y consulta de ventas.
* Actualización y eliminación de registros.
* Formularios HTML/PHP.
* Sistema básico de inicio de sesión.
* Exportación de información a Excel.
* Dashboard de ventas.

## 🚀 Instalación local

Para ejecutar el proyecto localmente se puede utilizar **XAMPP**.

### 1. Clonar el repositorio

```bash
git clone https://github.com/musicoariel4/tienda-online-mysql-excel.git
```

### 2. Copiar el proyecto

Colocar el proyecto dentro de:

```text
C:\xampp\htdocs\
```

### 3. Crear la base de datos

Abrir **phpMyAdmin** y ejecutar el archivo:

```text
sql/tienda_online.sql
```

### 4. Configurar la conexión

Crear localmente el archivo:

```text
html_php/dashboard_tienda_online/config.php
```

con las credenciales correspondientes a la instalación local.

> El archivo `config.php` no se incluye en GitHub porque contiene información de conexión local.

### 5. Iniciar XAMPP

Activar:

* Apache
* MySQL

Luego acceder al proyecto desde el navegador mediante:

```text
http://localhost/tienda-online-mysql-excel/html_php/
```

## 🔐 Seguridad

Las credenciales de conexión a la base de datos se mantienen fuera del repositorio mediante `.gitignore`.

No se deben publicar contraseñas, tokens ni credenciales reales en GitHub.

## 📚 Propósito del proyecto

Este proyecto forma parte de mi portafolio de desarrollo y análisis de datos y demuestra experiencia práctica en:

**MySQL + PHP + Excel + visualización de datos + Git/GitHub.**

## 👨‍💻 Autor

**Ariel Escobar**

Programación · Bases de datos · Excel · Análisis de datos
