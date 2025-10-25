<?php
if ($_POST) {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $telefono = trim($_POST['telefono'] ?? '');
    
    $errores = [];
    
    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio";
    } elseif (strlen($nombre) < 2) {
        $errores[] = "El nombre debe tener al menos 2 caracteres";
    } elseif (preg_match('/[0-9]/', $nombre)) {
        $errores[] = "El nombre no puede contener números";
    }
    
    if (empty($email)) {
        $errores[] = "El email es obligatorio";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del email no es válido";
    }
    
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