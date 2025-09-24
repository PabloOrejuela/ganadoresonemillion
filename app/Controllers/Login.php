<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Login extends BaseController {

    public function index() {

        $estadoSistema = $this->sistemaModel->select('estado')->first();

        if ($estadoSistema->estado == '0') {
            $data['title'] = 'Sitio en mantenimiento';
            $data['main_content'] = 'home/mantenimiento';
            return view('dashboard/index_mantenimiento', $data);
        }else{
            $data['title'] = '';
            $data['subtitle']='';
            $data['main_content'] = 'home/login';
            return view('dashboard/index_login', $data);
        }
    }

    public function forgotPassword(){

        $data['title'] = '';
        $data['subtitle']='Recupear contraseña';
        $data['main_content'] = 'home/recuperar_password';
        return view('dashboard/index_login', $data);
    }

    public function recuperaPassword() {

        $email = $this->request->getPostGet('email');

        //verificar si el email existe
        $usuario = $this->usuarioModel->select('id,email')->where('email', $email)->first();

        if (!$usuario) {

            $data['title'] = '';
            $data['subtitle']='El email proporcionado no está registrado en el sistema';

            $this->session->setFlashdata('mensaje', $data);
            //$this->logout();
            return redirect()->back()->with(
                'mensaje', 
                'Hubo un problema, el email proporcionado no está registrado en el sistema'
            );
        }else{

            //Creo un password nuevo
            $passwordNuevo = $this->generarPassword(10);

            // generamos el hash a partir de la contraseña enviada desde el formulario
            $pass_hashed = password_hash($passwordNuevo, PASSWORD_BCRYPT);

            //Inserto el nuevo password en la base de datos
            $user = [
                'password' => $pass_hashed
            ];

            $res = $this->usuarioModel->update($usuario->id, $user);

            //Envío el email con el nuevo password
            $res = $this->emailPassword($email, $passwordNuevo);

            if ($res) {

            $data['title'] = '';
            $data['subtitle']='Ingreso al sistema';

            $this->session->setFlashdata('mensaje', $data);
            return redirect()->back()->with(
                'mensaje', 
                'Su nueva contraseña ha sido enviada a su email registrado, por favor revise la carpeta de no deseados'
            );
            }else{
                $data['title'] = '';
                $data['subtitle']='Ingreso al sistema';

                $this->session->setFlashdata('mensaje', $data);
                return redirect()->back()->with(
                    'mensaje', 
                    'Hubo un problema, por favor inténtelo mas tarde'
                );
            }
        }
    }

    /**
     * Genera una contraseña aleatoria y segura.
     *
     * @param int $length La longitud deseada para la contraseña.
     * @return string La contraseña generada.
     */
    private function generarPassword(int $length = 10): string {

        // Define el conjunto de caracteres a utilizar
        $lower = 'abcdefghijklmnopqrstuvwxyz';
        $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $symbols = '!@#$%^&*()_+-=[]{}|';

        // Combina todos los caracteres
        $allCharacters = $lower . $upper . $numbers . $symbols;

        $password = '';

        // Asegura que la contraseña contenga al menos un caracter de cada tipo
        $password .= $lower[random_int(0, strlen($lower) - 1)];
        $password .= $upper[random_int(0, strlen($upper) - 1)];
        $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        $password .= $symbols[random_int(0, strlen($symbols) - 1)];

        // Rellena el resto de la contraseña con caracteres aleatorios
        for ($i = strlen($password); $i < $length; $i++) {
            $password .= $allCharacters[random_int(0, strlen($allCharacters) - 1)];
        }

        // Mezcla los caracteres para que los primeros no sean predecibles
        return str_shuffle($password);
    }

    public function emailPassword($correo, $passwordNuevo){

        $email = \Config\Services::email();
        
        $email->setFrom('appdvp.dev@gmail.com', 'Admin','appdvp.dev@gmail.com');
        $email->setReplyTo('porejuelac@gmail.com');

        $email->setTo($correo);

        $email->setCC('appdvp.dev@gmail.com');

        $email->setSubject('Nueva contraseña');

        $email->setMessage('Hemos reseteado su contraseña, su nueva contraseña es: ' . $passwordNuevo);

        $res = $email->send();

        
        return $res;
    }

}
