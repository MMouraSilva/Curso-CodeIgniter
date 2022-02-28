<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restrict extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library("session");
    }

    public function index() {

        if($this->session->userData("userID")) {
            $data = array(
                "styles" => array(
                    "dataTables.bootstrap.min.css",
                    "datatables.min.css"
                ),
                "scripts" => array(
                    "sweetalert2.all.min.js",
                    "dataTables.bootstrap.min.js",
                    "datatables.min.js",
                    "util.js",
                    "restrict.js"
                ),
                "userID" => $this->session->userdata("userID"),
            );
            $this->template->show("restrict.php", $data);
        } else {
            $data = array(
                "scripts" => array(
                    "util.js",
                    "login.js"
                )
            );
            $this->template->show("login.php", $data);
        }
    }

    public function logoff() {
        $this->session->sess_destroy();
        header("Location: " . base_url() . "restrict");
    }

    public function ajax_login() {

        if(!$this->input->is_ajax_request()) {
            exit("Nenhum acesso de script direto permitido!");
        }

        $json = array();
        $json["status"] = 1;
        $json["error_list"] = array();

        $username = $this->input->post("username");
        $password = $this->input->post("password");

        if(empty($username)) {
            $json["status"] = 0;
            $json["error_list"]["#username"] = 'Usuário não pode ser vazio!';
        } else {
            $this->load->model("users_model");
            $result = $this->users_model->get_user_data($username);
            if($result) {
                $userID = $result->userID;
                $passwordHash = $result->passwordHash;
                if(password_verify($password, $passwordHash)) {
                    $this->session->set_userdata("userID", $userID);
                } else {
                    $json["status"] = 0;
                }
            } else {
                $json["status"] = 0;
            }
            if($json["status"] == 0) {
                $json["error_list"]["#btn_login"] = "Usuário e/ou senha incorretos";
            }
        }

        echo json_encode($json);
    }
    
    public function ajax_import_image() {
        if(!$this->input->is_ajax_request()) {
            exit("Nenhum acesso de script direto permitido!");
        }

        $config["upload_path"] = "./tmp/";
        $config["allowed_types"] = "gif|png|jpg";
        $config["overwrite"] = TRUE;

        $this->load->library("upload", $config);

        $json = array();
        $json["status"] = 1;

        if(!$this->upload->do_upload("image_file")) {
            $json["status"] = 0;
            $json["error"] = $this->upload->display_errors("", "");
        } else {
            if($this->upload->data()["file_size"] <= 1024) {
                $file_name = $this->upload->data()["file_name"];
                $json["img_path"] = base_url() . "tmp/" . $file_name;
            } else {
                $json["status"] = 0;
                $json["error"] = "Arquivo não deve ser maior que 1MB!";
            }
        }

        echo json_encode($json);
    }

    public function ajax_save_course() {
        if(!$this->input->is_ajax_request()) {
            exit("Nenhum acesso de script direto permitido!");
        }

        $json = array();
        $json["status"] = 1;
        $json["error_list"] = array();

        $this->load->model("courses_model");

        $data = $this->input->post();

        if(empty($data["courseName"])) {
            $json["error_list"]["#courseName"] = "Nome do curso é obrigatório!";
        } else {
            if($this->courses_model->is_duplicated("courseName", $data["courseName"], $data["courseID"])) {
                $json["error_list"]["#courseName"] = "Nome de curso já existente!";
            }
        }

        $data["courseDuration"] = floatval($data["courseDuration"]);
        if(empty($data["courseDuration"])) {
            $json["error_list"]["#courseDuration"] = "Duração do curso é obrigatória!";
        } else {
            if(!($data["courseDuration"] > 0 && $data["courseDuration"] < 100)) {
                $json["error_list"]["#courseDuration"] = "Duração do curso deve ser maior que 0 (h) e menor que 100 (h)!";
            }
        }
        

        if(!empty($json["error_list"])) {
            $json["status"] = 0;
        } else {
            if(!empty($data["courseImg"])) {
                $file_name = basename($data["courseImg"]);
                $old_path = getcwd() . "/tmp/" . $file_name;
                $new_path = getcwd() . "/public/images/courses/" . $file_name;
                rename($old_path, $new_path);

                $data["courseImg"] = "/public/images/courses/" . $file_name;
            } else {
                unset($data["courseImg"]);
            }

            if(empty($data["courseID"])) {
                $this->courses_model->insert($data);
            } else {
                $courseID = $data["courseID"];
                unset($data["courseID"]);
                $this->courses_model->update($courseID, $data);
            }
        }

        echo json_encode($json);
    }
    
    public function ajax_save_member() {
        if(!$this->input->is_ajax_request()) {
            exit("Nenhum acesso de script direto permitido!");
        }

        $json = array();
        $json["status"] = 1;
        $json["error_list"] = array();

        $this->load->model("team_model");

        $data = $this->input->post();

        if(empty($data["memberName"])) {
            $json["error_list"]["#memberName"] = "Nome do membro é obrigatório!";
        }        

        if(!empty($json["error_list"])) {
            $json["status"] = 0;
        } else {
            if(!empty($data["memberPhoto"])) {
                $file_name = basename($data["memberPhoto"]);
                $old_path = getcwd() . "/tmp/" . $file_name;
                $new_path = getcwd() . "/public/images/team/" . $file_name;
                rename($old_path, $new_path);

                $data["memberPhoto"] = "/public/images/team/" . $file_name;
            } else {
                unset($data["memberPhoto"]);
            }

            if(empty($data["memberID"])) {
                $this->team_model->insert($data);
            } else {
                $memberID = $data["memberID"];
                unset($data["memberID"]);
                $this->team_model->update($memberID, $data);
            }
        }

        echo json_encode($json);
    }

    public function ajax_save_user() {
        if(!$this->input->is_ajax_request()) {
            exit("Nenhum acesso de script direto permitido!");
        }

        $json = array();
        $json["status"] = 1;
        $json["error_list"] = array();

        $this->load->model("users_model");

        $data = $this->input->post();

        if(empty($data["userLogin"])) {
            $json["error_list"]["#userLogin"] = "Login obrigatório!";
        } else {
            if($this->users_model->is_duplicated("userLogin", $data["userLogin"], $data["userID"])) {
                $json["error_list"]["#userLogin"] = "Login já existente!";
            }
        }

        if(empty($data["userFullName"])) {
            $json["error_list"]["#userFullName"] = "Nome é obrigatório!";
        }

        if(empty($data["userEmail"])) {
            $json["error_list"]["#userEmail"] = "E-mail é obrigatório!";
        } else if($this->users_model->is_duplicated("userEmail", $data["userEmail"], $data["userID"])) {
            $json["error_list"]["#userEmail"] = "E-mail já existente!";
        } else if(!($data["userEmail"] === $data["user_email_confirm"])) {
            $json["error_list"]["#userEmail"] = "";
            $json["error_list"]["#user_email_confirm"] = "E-mails não conferem!";
        }


        if(empty($data["userPassword"])) {
            $json["error_list"]["#userPassword"] = "Senha é obrigatória!";
        } else if(!($data["userPassword"] == $data["user_password_confirm"])) {
            $json["error_list"]["#userPassword"] = "";
            $json["error_list"]["#user_password_confirm"] = "Senhas não conferem!";
        }
        

        if(!empty($json["error_list"])) {
            $json["status"] = 0;
        } else {

            $data["passwordHash"] = password_hash($data["userPassword"], PASSWORD_DEFAULT);
            unset($data["user_email_confirm"]);
            unset($data["userPassword"]);
            unset($data["user_password_confirm"]);
            
            if(empty($data["userID"])) {
                $this->users_model->insert($data);
            } else {
                $userID = $data["userID"];
                unset($data["userID"]);
                $this->users_model->update($userID, $data);
            }
        }

        echo json_encode($json);
    }

    public function ajax_get_course_data() {
        if(!$this->input->is_ajax_request()) {
            exit("Nenhum acesso de script direto permitido!");
        }

        $json = array();
        $json["status"] = 1;
        $json["input"] = array();

        $this->load->model("courses_model");

        $courseID = $this->input->post("courseID");
        $data = $this->courses_model->get_data($courseID)->result_array()[0];
        $json["input"]["courseID"] = $data["courseID"];
        $json["input"]["courseName"] = $data["courseName"];
        $json["img"]["course_img_path"] = base_url() . $data["courseImg"];
        $json["input"]["courseDuration"] = $data["courseDuration"];
        $json["input"]["courseDescription"] = $data["courseDescription"];

        echo json_encode($json);
    }

    public function ajax_get_member_data() {
        if(!$this->input->is_ajax_request()) {
            exit("Nenhum acesso de script direto permitido!");
        }

        $json = array();
        $json["status"] = 1;
        $json["input"] = array();

        $this->load->model("team_model");

        $memberID = $this->input->post("memberID");
        $data = $this->team_model->get_data($memberID)->result_array()[0];
        $json["input"]["memberID"] = $data["memberID"];
        $json["input"]["memberName"] = $data["memberName"];
        $json["img"]["member_photo_path"] = base_url() . $data["memberPhoto"];
        $json["input"]["memberDescription"] = $data["memberDescription"];

        echo json_encode($json);
    }

    public function ajax_get_user_data() {
        if(!$this->input->is_ajax_request()) {
            exit("Nenhum acesso de script direto permitido!");
        }

        $json = array();
        $json["status"] = 1;
        $json["input"] = array();

        $this->load->model("users_model");

        $userID = $this->input->post("userID");
        $data = $this->users_model->get_data($userID)->result_array()[0];
        $json["input"]["userID"] = $data["userID"];
        $json["input"]["userLogin"] = $data["userLogin"];
        $json["input"]["userFullName"] = $data["userFullName"];
        $json["input"]["userEmail"] = $data["userEmail"];
        $json["input"]["user_email_confirm"] = $data["userEmail"];
        $json["input"]["userPassword"] = $data["passwordHash"];
        $json["input"]["user_password_confirm"] = $data["passwordHash"];

        echo json_encode($json);
    }

    public function ajax_delete_course_data() {
        if(!$this->input->is_ajax_request()) {
            exit("Nenhum acesso de script direto permitido!");
        }

        $json = array();
        $json["status"] = 1;

        $this->load->model("courses_model");
        $courseID = $this->input->post("courseID");
        $this->courses_model->delete($courseID);

        echo json_encode($json);
    }

    public function ajax_delete_member_data() {
        if(!$this->input->is_ajax_request()) {
            exit("Nenhum acesso de script direto permitido!");
        }

        $json = array();
        $json["status"] = 1;

        $this->load->model("team_model");
        $memberID = $this->input->post("memberID");
        $this->team_model->delete($memberID);

        echo json_encode($json);
    }

    public function ajax_delete_user_data() {
        if(!$this->input->is_ajax_request()) {
            exit("Nenhum acesso de script direto permitido!");
        }

        $json = array();
        $json["status"] = 1;

        $this->load->model("users_model");
        $userID = $this->input->post("userID");
        $this->users_model->delete($userID);

        echo json_encode($json);
    }

    public function ajax_list_course() {
        if(!$this->input->is_ajax_request()) {
            exit("Nenhum acesso de script direto permitido!");
        }

        $this->load->model("courses_model");
        $courses = $this->courses_model->get_datatable();

        $data = array();
        foreach($courses as $course) {
            $row = array();
            $row[] = $course->courseName;

            if($course->courseImg) {
                $row[] = '<img src="'. base_url() . $course->courseImg .'" style="max-height: 100px; max-width: 100px;">';
            } else {
                $row[] = "";
            }

            $row[] = $course->courseDuration;
            $row[] = '<div class="description">' . $course->courseDescription . '</div>';

            $row[] = '<div style="display: inline-block;">
                        <button class="btn btn-primary btn-edit-course" courseID="'. $course->courseID .'">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-del-course" courseID="'. $course->courseID .'">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>';

            $data[] = $row;
        }

        $json = array(
            "draw" => $this->input->post("draw"),
            "recordsTotal" => $this->courses_model->records_total(),
            "recordsFiltered" => $this->courses_model->records_filtered(),
            "data" => $data,
        );

        echo json_encode($json);
    }

    public function ajax_list_member() {
        if(!$this->input->is_ajax_request()) {
            exit("Nenhum acesso de script direto permitido!");
        }

        $this->load->model("team_model");
        $team = $this->team_model->get_datatable();

        $data = array();
        foreach($team as $member) {
            $row = array();
            $row[] = $member->memberName;

            if($member->memberPhoto) {
                $row[] = '<img src="'. base_url() . $member->memberPhoto .'" style="max-height: 100px; max-width: 100px;">';
            } else {
                $row[] = "";
            }

            $row[] = '<div class="description">' . $member->memberDescription . '</div>';

            $row[] = '<div style="display: inline-block;">
                        <button class="btn btn-primary btn-edit-member" memberID="'. $member->memberID .'">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-del-member" memberID="'. $member->memberID .'">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>';

            $data[] = $row;
        }

        $json = array(
            "draw" => $this->input->post("draw"),
            "recordsTotal" => $this->team_model->records_total(),
            "recordsFiltered" => $this->team_model->records_filtered(),
            "data" => $data,
        );

        echo json_encode($json);
    }

    public function ajax_list_user() {
        if(!$this->input->is_ajax_request()) {
            exit("Nenhum acesso de script direto permitido!");
        }

        $this->load->model("users_model");
        $users = $this->users_model->get_datatable();

        $data = array();
        foreach($users as $user) {
            $row = array();
            $row[] = $user->userLogin;
            $row[] = $user->userFullName;
            $row[] = $user->userEmail;

            $row[] = '<div style="display: inline-block;">
                        <button class="btn btn-primary btn-edit-user" userID="'. $user->userID .'">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-del-user" userID="'. $user->userID .'">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>';

            $data[] = $row;
        }

        $json = array(
            "draw" => $this->input->post("draw"),
            "recordsTotal" => $this->users_model->records_total(),
            "recordsFiltered" => $this->users_model->records_filtered(),
            "data" => $data,
        );

        echo json_encode($json);
    }
}
