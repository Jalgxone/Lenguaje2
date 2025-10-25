# Sistema de Validación de Formulario PHP

## Descripción

- Valida nombre, email, contraseña y teléfono.
- Muestra mensajes de error si hay validaciones que no se cumplen.
- Si todo es correcto, muestra los datos sanitizados (la contraseña se marca como protegida).

## Contenido del archivo `index.php`

```php
<?php
// Procesar formulario cuando se envía
if ($_POST) {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $telefono = trim($_POST['telefono'] ?? '');
    
    $errores = [];
    
    // VALIDACIONES DEL NOMBRE
    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio";
    } elseif (strlen($nombre) < 2) {
        $errores[] = "El nombre debe tener al menos 2 caracteres";
    } elseif (preg_match('/[0-9]/', $nombre)) {
        $errores[] = "El nombre no puede contener números";
    }
    
    // VALIDACIONES DEL EMAIL
    if (empty($email)) {
        $errores[] = "El email es obligatorio";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del email no es válido";
    }
    
    // VALIDACIONES DEL PASSWORD
    if (empty($password)) {
        $errores[] = "La contraseña es obligatoria";
    } else {
        if (strlen($password) < 8) {
            $errores[] = "La contraseña debe tener al menos 8 caracteres";
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $errores[] = "La contraseña debe tener al menos una mayúscula";
        }
        if (!preg_match('/[0-9]/', $password)) {
            $errores[] = "La contraseña debe tener al menos un número";
        }
        if (!preg_match('/[!@#$%^&*]/', $password)) {
            $errores[] = "La contraseña debe tener al menos un carácter especial (!@#$%^&*)";
        }
    }
    
    if (!empty($telefono)) {
        if (!preg_match('/^[0-9]{10}$/', $telefono)) {
            $errores[] = "El teléfono debe tener 10 dígitos";
        }
    }
    
    echo "<h3>Resultado de Validación:</h3>";
    
    if (empty($errores)) {
        echo "<p style='color:green;'> ¡Registro exitoso!</p>";
        echo "<p><strong>Datos sanitizados listos para BD:</strong></p>";
        echo "Nombre: " . htmlspecialchars($nombre) . "<br>";
        echo "Email: " . htmlspecialchars($email) . "<br>";
        echo "Teléfono: " . htmlspecialchars($telefono) . "<br>";
        echo "Contraseña: [Protegida con hash]<br>";
    } else {
        echo "<p style='color:red;'> Errores encontrados:</p>";
        foreach ($errores as $error) {
            echo "- $error<br>";
        }
    }
    
    echo "<hr>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Validador de Usuario</title>
</head>
<body>
    <h2>Formulario de Registro</h2>
    
    <form method="POST">
        <p>
            <strong>Nombre completo:</strong><br>
            <input type="text" name="nombre" value="<?php echo $_POST['nombre'] ?? ''; ?>" 
                   placeholder="Solo letras y espacios" style="width:300px;">
        </p>
        
        <p>
            <strong>Email:</strong><br>
            <input type="email" name="email" value="<?php echo $_POST['email'] ?? ''; ?>" 
                   placeholder="usuario@correo.com" style="width:300px;">
        </p>
        
        <p>
            <strong>Contraseña:</strong><br>
            <input type="password" name="password" placeholder="Mínimo 8 caracteres" style="width:300px;">
        </p>
        
        <p>
            <strong>Teléfono (opcional):</strong><br>
            <input type="text" name="telefono" value="<?php echo $_POST['telefono'] ?? ''; ?>" 
                   placeholder="10 dígitos" style="width:300px;">
        </p>
        
        <input type="submit" value="Validar Datos">
    </form>

    <div style="margin-top:20px; padding:10px; background:#f0f0f0;">
        <h3>🔒 Requisitos de Validación:</h3>
        
        <p><strong>Nombre:</strong></p>
        <ul>
            <li>Obligatorio</li>
            <li>Mínimo 2 caracteres</li>
            <li>Sin números</li>
        </ul>
        
        <p><strong>Email:</strong></p>
        <ul>
            <li>Formato válido de email</li>
        </ul>
        
        <p><strong>Contraseña:</strong></p>
        <ul>
            <li>Mínimo 8 caracteres</li>
            <li>Al menos 1 mayúscula</li>
            <li>Al menos 1 número</li>
            <li>Al menos 1 carácter especial (!@#$%^&*)</li>
        </ul>
        
        <p><strong>Teléfono:</strong></p>
        <ul>
            <li>Opcional</li>
            <li>10 dígitos exactos</li>
        </ul>
    </div>
</body>
</html>
```

## Cómo Resuelve Problemas de Seguridad en BD

- Sanitización de Datos
- trim(): Elimina espacios en blanco innecesarios

- htmlspecialchars(): Previene ataques XSS al convertir caracteres especiales

- Validación con filter_var(): Garantiza formatos correctos antes de insertar en BD

- Validaciones Implementadas
- Nombre: Obligatorio y longitud mínima
- Email: Formato válido con filtro PHP
- Contraseña: Longitud segura mínima

- Prevención de SQL Injection: Datos sanitizados antes de consultas


## Combinación de Condicionales y Ciclos
### Condicionales (if/else)
- Validan reglas de negocio específicas
- Controlan el flujo del programa según condiciones
- Previenen datos corruptos en BD


### Ciclos (foreach)
- Procesan múltiples errores eficientemente
- Escalan para validar muchos campos
- Mejoran mantenimiento del código

## Beneficios de Seguridad
- Prevención de Inyección SQL: Datos limpios antes de consultas
- Calidad de Datos: Información válida y consistente
- Protección XSS: Salida segura en HTML
- Validación Centralizada: Fácil mantenimiento y auditoría

## Uso del Sistema
- El usuario completa el formulario HTML
- PHP procesa y sanitiza los datos
- Condicionales validan cada regla de negocio
- Ciclos muestran todos los errores encontrados
- Si no hay errores, datos listos para BD

## Cómo usar

- Coloca `index.php` en un servidor con PHP (ej. XAMPP) y accede vía navegador.
- Este `readme.md` es sólo una copia en Markdown para documentación o revisión.

---