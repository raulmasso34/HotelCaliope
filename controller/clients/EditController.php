<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ .'../../../modelo/clientesModelo/EditModel.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class EditController {
    private $editModel;
    
    public function __construct($db) {
        $this->editModel = new EditModel($db);
    }
    
    // Obtener datos del cliente para mostrar en el formulario
    public function getClientData($clientId) {
        return $this->editModel->getClientById($clientId);
    }
    
    // Procesar la actualización de credenciales
    public function updateCredentials($clientId, $newUsername, $currentPassword, $newPassword = '') {
        // Validar datos
        if (empty($newUsername)) {
            return ['error' => 'El nombre de usuario no puede estar vacío'];
        }
        
        // Verificar si el nombre de usuario está disponible
        if (!$this->editModel->isUsernameAvailable($newUsername, $clientId)) {
            return ['error' => 'Este nombre de usuario ya está en uso'];
        }
        
        // Obtener datos actuales del cliente
        $clientData = $this->editModel->getClientById($clientId);
        if (!$clientData) {
            return ['error' => 'No se encontró el cliente'];
        }
        
        // Si se está cambiando la contraseña, verificar la contraseña actual
        if (!empty($newPassword)) {
            // Verificar si la contraseña actual es correcta
            if (!password_verify($currentPassword, $clientData['Password'])) {
                return ['error' => 'La contraseña actual no es correcta'];
            }
            
            // Actualizar usuario y contraseña
            if ($this->editModel->updateUserCredentials($clientId, $newUsername, $newPassword)) {
                return ['success' => 'Nombre de usuario y contraseña actualizados correctamente'];
            } else {
                return ['error' => 'Error al actualizar las credenciales'];
            }
        } else {
            // Solo actualizar el nombre de usuario
            if ($this->editModel->updateUserCredentials($clientId, $newUsername)) {
                return ['success' => 'Nombre de usuario actualizado correctamente'];
            } else {
                return ['error' => 'Error al actualizar el nombre de usuario'];
            }
        }
    }
    
    // Obtener historial de cambios
    public function getClientHistory($clientId) {
        return $this->editModel->getClientHistory($clientId);
    }
}
?>