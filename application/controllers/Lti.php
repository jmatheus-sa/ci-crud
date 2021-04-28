<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use models\entidades\Dependente;
use models\entidades\Funcionario;
use models\entidades\Endereco;

class Lti extends CI_Controller {

	public $em;

	function __construct()
	{
		parent::__construct();
		$this->em = $this->doctrine->em;
	}

	public function index()
	{
		$data = array('title' => 'LTI', 'activeUrl' => '');
		$this->load->view('templates/header.php', $data);
		$this->load->view('templates/side_menu.php');
		$this->load->view('templates/footer.php');
	}

	public function cadastro()
	{
		$ufRepository = $this->em->getRepository('models\entidades\Estado');
        $ufs = $ufRepository->findAll();
		$ufsASC = array();
		foreach($ufs as $uf){
			$ufsASC[] = $uf->getUf();
		}
		sort($ufsASC, SORT_STRING);
		
		$data = array('title' => 'LTI - Cadastro', 'formTitle' => 'Cadastrar Funcionário',  'activeUrl' => 'newEmp', 'bttnId' => 'register-emp', 'ufs' => $ufsASC);
		$this->load->view('templates/header.php', $data);
		$this->load->view('templates/side_menu.php', $data);
		$this->load->view('pages/newemployee.php', $data);
		$this->load->view('templates/footer.php');

	}

	public function cadastroAction(){
		$result = array();
		$this->load->library('form_validation');
		$ufRepository = $this->em->getRepository('models\entidades\Estado');
		$config = array(
			array(
				'field' => 'name',
				'label' => 'Nome',
				'rules' => array('required','trim','htmlspecialchars','stripslashes','regex_match[/^[A-Za-z ]*$/i]'),
				'errors' => array(
					'required' => 'O campo Nome é obrigatório*',
					'regex_match' => 'Formato de nome inválido'
				)
			),
			array(
				'field' => 'cpf',
				'label' => 'CPF',
				'rules' => array('required','trim','htmlspecialchars','stripslashes','regex_match[/^[0-9]*$/i]','exact_length[11]'),
				'errors' => array(
					'required' => 'O campo CPF é obrigatório*',
					'regex_match' => 'Apenas números são permitidos no campo CPF*',
					'exact_length' => 'Formato de CPF inválido*'
				)
			),
			array(
				'field' => 'department',
				'label' => 'Departamento',
				'rules' => array('required','trim','htmlspecialchars','stripslashes','regex_match[/^[A-Za-z ]*$/i]'),
				'errors' => array(
					'required' => 'O campo Departamento é obrigatório*',
					'regex_match' => 'Apenas letras e espaços são permitidos no campo Departamento*'
				)
			),
			array(
				'field' => 'street',
				'label' => 'Rua',
				'rules' => array('required','trim','htmlspecialchars','stripslashes','regex_match[/^[A-Za-z0-9.\' ]*$/i]'),
				'errors' => array(
					'required' => 'O campo Rua é obrigatório*',
					'regex_match' => 'Apenas letras, números, espaços e os caracteres . \' são permitidos no campo Rua*'
				)
			),
			array(
				'field' => 'district',
				'label' => 'Bairro',
				'rules' => array('required','trim','htmlspecialchars','stripslashes','regex_match[/^[A-Za-z0-9.\' ]*$/i]'),
				'errors' => array(
					'required' => 'O campo Bairro é obrigatório*',
					'regex_match' => 'Apenas letras, números, espaços e os caracteres . \' são permitidos no campo Bairro*'
				)
			),
			array(
				'field' => 'number',
				'label' => 'Número',
				'rules' => array('required','trim','htmlspecialchars','stripslashes','regex_match[/^[0-9]*$/i]'),
				'errors' => array(
					'required' => 'O campo Número é obrigatório*',
					'regex_match' => 'Apenas números são permitidos no campo Número*'
				)
			),
			array(
				'field' => 'city',
				'label' => 'Cidade',
				'rules' => array('required','trim','htmlspecialchars','stripslashes','regex_match[/^[A-Za-z ]*$/i]'),
				'errors' => array(
					'required' => 'O campo Cidade é obrigatório*',
					'regex_match' => 'Apenas letras e espaços são permitidos no campo Cidade*'
				)
			)
		);
		$this->form_validation->set_rules($config);
		if(!($this->form_validation->run() == FALSE)){
			$form_data = $this->input->post();
			$endereco = new Endereco();
			$endereco->setRua($form_data['street']);
			$endereco->setBairro($form_data['district']);
			$endereco->setNumero($form_data['number']);
			$endereco->setCidade($form_data['city']);
			$estado = $ufRepository->findOneBy(array('uf' => (string)$form_data['state']));
			$endereco->setEstado($estado);
			$estado->addEnderecos($endereco);

			$funcionario = new Funcionario();
			$funcionario->setNome($form_data['name']);
			$funcionario->setCpf($form_data['cpf']);
			$funcionario->setEndereco($endereco);
			$funcionario->setDepartamento($form_data['department']);

			$this->em->flush();
			$result['success'] = true;
			$result['message'] = "Funcionário cadastrado com sucesso!";
			
		}else{
			$result['success'] = false;
			$result['message'] = "Formulário inválido";
		}

		print json_encode($result);
	}

	public function funcionarios()
	{
		// Recuperar funcionário do banco de dados
		$funcRepository = $this->em->getRepository('models\entidades\Funcionario');
		$funcionarios = $funcRepository->findAll();
		$funcionario = array();
		$dependente = array();
		$i = $ii = 0;
		$nDeps = array();
		foreach($funcionarios as $func){
			$funcionario[$i]['id'] = $func->getId();
			$funcionario[$i]['nome'] = $func->getNome();
			$funcionario[$i]['cpf'] = $func->getCpf();
			$funcionario[$i]['departamento'] = $func->getDepartamento();
			$endereco = $func->getEndereco();
			$funcionario[$i]['rua'] = $endereco->getRua();
			$funcionario[$i]['bairro'] = $endereco->getBairro();
			$funcionario[$i]['cidade'] = $endereco->getCidade();
			$funcionario[$i]['numero'] = $endereco->getNumero();
			$estado = $endereco->getEstado();
			$funcionario[$i]['estadouf'] = $estado->getUf();
			$funcionario[$i]['estadonome'] = $estado->getNome();

			$dependentes = $func->getDependentes();
			$nDeps[$i] = 0;
			foreach($dependentes as $dep){
				$dependente[$i][$ii]['id'] = $dep->getId();
				$dependente[$i][$ii]['nome'] = $dep->getNome();
				$dependente[$i][$ii]['idade'] = $dep->getIdade();
				$dependente[$i][$ii]['cpf'] = $dep->getCpf();
				$ii++;
				$nDeps[$i]++;
			}
			$ii = 0;

			$i++;
		}

		$data = array('title' => 'LTI - Funcionários', 'activeUrl' => 'emps', 'funcionario' => $funcionario, 'dependente' => $dependente, 'nFunc' => $i,
				'nDeps' => $nDeps);
		$this->load->view('templates/header.php', $data);
		$this->load->view('templates/side_menu.php', $data);
		$this->load->view('pages/employees.php', $data);
		$this->load->view('templates/footer.php');
	}

	public function editar_cadastro()
	{
		$ufRepository = $this->em->getRepository('models\entidades\Estado');
        $ufs = $ufRepository->findAll();
		$ufsASC = array();
		foreach($ufs as $uf){
			$ufsASC[] = $uf->getUf();
		}
		sort($ufsASC, SORT_STRING);
		
		$data = array('title' => 'LTI - Cadastro', 'formTitle' => 'Editar Cadastro', 'activeUrl' => '', 'bttnId' => 'edit-register-emp', 'ufs' => $ufsASC);
		$this->load->view('templates/header.php', $data);
		$this->load->view('templates/side_menu.php', $data);
		$this->load->view('pages/newemployee.php', $data);
		$this->load->view('templates/footer.php');

	}

	public function editar_cadastroAction($id){
		$this->load->library('form_validation');
		$ufRepository = $this->em->getRepository('models\entidades\Estado');
		$empRepository = $this->em->getRepository('models\entidades\Funcionario');
		$employees = $empRepository->findAll();
		$result = array();
		$config = array(
				array(
					'field' => 'name',
					'label' => 'Nome',
					'rules' => array('required','trim','htmlspecialchars','stripslashes','regex_match[/^[A-Za-z ]*$/i]'),
					'errors' => array(
						'required' => 'O campo Nome é obrigatório*',
						'regex_match' => 'Formato de nome inválido'
					)
				),
				array(
					'field' => 'cpf',
					'label' => 'CPF',
					'rules' => array('required','trim','htmlspecialchars','stripslashes','regex_match[/^[0-9]*$/i]','exact_length[11]'),
					'errors' => array(
						'required' => 'O campo CPF é obrigatório*',
						'regex_match' => 'Apenas números são permitidos no campo CPF*',
						'exact_length' => 'Formato de CPF inválido*'
					)
				),
				array(
					'field' => 'department',
					'label' => 'Departamento',
					'rules' => array('required','trim','htmlspecialchars','stripslashes','regex_match[/^[A-Za-z ]*$/i]'),
					'errors' => array(
						'required' => 'O campo Departamento é obrigatório*',
						'regex_match' => 'Apenas letras e espaços são permitidos no campo Departamento*'
					)
				),
				array(
					'field' => 'street',
					'label' => 'Rua',
					'rules' => array('required','trim','htmlspecialchars','stripslashes','regex_match[/^[A-Za-z0-9.\' ]*$/i]'),
					'errors' => array(
						'required' => 'O campo Rua é obrigatório*',
						'regex_match' => 'Apenas letras, números, espaços e os caracteres . \' são permitidos no campo Rua*'
					)
				),
				array(
					'field' => 'district',
					'label' => 'Bairro',
					'rules' => array('required','trim','htmlspecialchars','stripslashes','regex_match[/^[A-Za-z0-9.\' ]*$/i]'),
					'errors' => array(
						'required' => 'O campo Bairro é obrigatório*',
						'regex_match' => 'Apenas letras, números, espaços e os caracteres . \' são permitidos no campo Bairro*'
					)
				),
				array(
					'field' => 'number',
					'label' => 'Número',
					'rules' => array('required','trim','htmlspecialchars','stripslashes','regex_match[/^[0-9]*$/i]'),
					'errors' => array(
						'required' => 'O campo Número é obrigatório*',
						'regex_match' => 'Apenas números são permitidos no campo Número*'
					)
				),
				array(
					'field' => 'city',
					'label' => 'Cidade',
					'rules' => array('required','trim','htmlspecialchars','stripslashes','regex_match[/^[A-Za-z ]*$/i]'),
					'errors' => array(
						'required' => 'O campo Cidade é obrigatório*',
						'regex_match' => 'Apenas letras e espaços são permitidos no campo Cidade*'
					)
				)
		);
		$this->form_validation->set_rules($config);
		if(!($this->form_validation->run() == FALSE)){
			$form_data = $this->input->post();

			foreach($employees as $employee){
				if($employee->getId() == (int)$id){
					$employee->setNome($form_data['name']);
					$employee->setCpf($form_data['cpf']);
					$employee->setDepartamento($form_data['department']);

					$address = $employee->getEndereco();
					$state = $address->getEstado();
					$state->getEnderecos()->removeElement($address);

					$address->setRua($form_data['street']);
					$address->setBairro($form_data['district']);
					$address->setNumero($form_data['number']);
					$address->setCidade($form_data['city']);
					$newState = $ufRepository->findOneBy(array('uf' => (string)$form_data['state']));
					$address->setEstado($newState);
					$newState->addEnderecos($address);
				}
			}

			$this->em->flush();

			$result['success'] = true;
			$result['message'] = "Cadastro editado com sucesso!";
		}else{
			$result['success'] = false;
			$result['message'] = "Formulário inválido";
		}

		print json_encode($result);
	}

	public function cadastro_dependente(){

		$this->load->library('form_validation');
		$config = array(
			array(
				'field' => 'name',
				'label' => 'Nome',
				'rules' => array('required','trim','htmlspecialchars','stripslashes','regex_match[/^[A-Za-z ]*$/i]'),
				'errors' => array(
					'required' => 'O campo Nome é obrigatório*',
					'regex_match' => 'Formato de nome inválido'
				)
			),
			array(
				'field' => 'cpf',
				'label' => 'CPF',
				'rules' => array('required','trim','htmlspecialchars','stripslashes','regex_match[/^[0-9]*$/i]','exact_length[11]'),
				'errors' => array(
					'required' => 'O campo CPF é obrigatório*',
					'regex_match' => 'Apenas números são permitidos no campo CPF*',
					'exact_length' => 'Formato de CPF inválido*'
				)
			),
			array(
				'field' => 'age',
				'label' => 'Idade',
				'rules' => array('required','trim','htmlspecialchars','stripslashes','regex_match[/^[0-9]*$/i]'),
				'errors' => array(
					'required' => 'O campo Idade é obrigatório*',
					'regex_match' => 'Apenas números são permitidos no campo Idade*'
				)
			),
		);
		$this->form_validation->set_rules($config);
		if(!($this->form_validation->run() == FALSE)){
			$form_data = $this->input->post();
			$funcionario = $this->em->find('models\entidades\Funcionario',(int)$_GET['id_func']);

			$dependente = new Dependente();
			$dependente->setNome($form_data['name']);
			$dependente->setCpf($form_data['cpf']);
			$dependente->setIdade($form_data['age']);
			$dependente->addFuncionario($funcionario);
			$funcionario->addDependente($dependente);

			$this->em->flush();
			
			redirect('/funcionarios');
		}

		$data = array('title' => 'LTI - Cadastro de Dependente', 'formTitle' => 'Cadastrar Dependente' ,'activeUrl' => '');
		$this->load->view('templates/header.php', $data);
		$this->load->view('templates/side_menu.php', $data);
		$this->load->view('pages/newdependent.php');
		$this->load->view('templates/footer.php');

	}

	public function editar_dependente(){

		$this->load->library('form_validation');
		$dependente = $this->em->find('models\entidades\Dependente', $_GET['id']);
		$config = array(
			array(
				'field' => 'name',
				'label' => 'Nome',
				'rules' => array('required','trim','htmlspecialchars','stripslashes','regex_match[/^[A-Za-z ]*$/i]'),
				'errors' => array(
					'required' => 'O campo Nome é obrigatório*',
					'regex_match' => 'Formato de nome inválido'
				)
			),
			array(
				'field' => 'cpf',
				'label' => 'CPF',
				'rules' => array('required','trim','htmlspecialchars','stripslashes','regex_match[/^[0-9]*$/i]','exact_length[11]'),
				'errors' => array(
					'required' => 'O campo CPF é obrigatório*',
					'regex_match' => 'Apenas números são permitidos no campo CPF*',
					'exact_length' => 'Formato de CPF inválido*'
				)
			),
			array(
				'field' => 'age',
				'label' => 'Idade',
				'rules' => array('required','trim','htmlspecialchars','stripslashes','regex_match[/^[0-9]*$/i]'),
				'errors' => array(
					'required' => 'O campo Idade é obrigatório*',
					'regex_match' => 'Apenas números são permitidos no campo Idade*'
				)
			),
		);
		$this->form_validation->set_rules($config);
		if(!($this->form_validation->run() == FALSE)){
			$form_data = $this->input->post();

			$dependente->setNome($form_data['name']);
			$dependente->setCpf($form_data['cpf']);
			$dependente->setIdade($form_data['age']);

			$this->em->flush();

			redirect('/funcionarios');
		}

		$data = array('title' => 'LTI - Cadastro de Dependente', 'formTitle' => 'Editar Dependente' ,'activeUrl' => '');
		$this->load->view('templates/header.php', $data);
		$this->load->view('templates/side_menu.php', $data);
		$this->load->view('pages/newdependent.php');
		$this->load->view('templates/footer.php');

	}
	
	// Funções

	public function delEmployee($id_func){
		$funcionario = $this->em->find('models\entidades\Funcionario', (int)$id_func);
		$this->em->remove($funcionario);

		$this->em->flush();

		redirect('/funcionarios');
	}

	public function delDependent($id_dep, $id_emp){
		$employee = $this->em->find('models\entidades\Funcionario', (int)$id_emp);
		$dependent = $this->em->find('models\entidades\Dependente', (int)$id_dep);
		$employee->getDependentes()->removeElement($dependent);
		$dependent->getFuncionarios()->removeElement($employee);
		
		if(count($dependent->getFuncionarios()) == 0){
			$this->em->remove($dependent);
		}

		$this->em->flush();

		redirect('/funcionarios');
	}

	public function depslist(){
		$depRepository = $this->em->getRepository('models\entidades\Dependente');
		$dependentsList = $depRepository->findAll();
		$depsList = array();
		$dCounter = 0;

		foreach($dependentsList as $dep){
			$depsList[$dCounter]['id'] = $dep->getId();
			$depsList[$dCounter]['nome'] = $dep->getNome();
			$depsList[$dCounter]['idade'] = $dep->getIdade();
			$depsList[$dCounter]['cpf'] = $dep->getCpf();
			$dCounter++;
		}

		$data = array('depsList' => $depsList, 'dCounter' => $dCounter);
		$this->load->view('pages/depslist.php', $data);
	}

	public function addDependent($id_emp, $id_dep){
		$employee = $this->em->find('models\entidades\Funcionario', (int)$id_emp);
		$dependent = $this->em->find('models\entidades\Dependente', (int)$id_dep);

		$employee->addDependente($dependent);
		$dependent->addFuncionario($employee);

		$this->em->flush();

		redirect('/funcionarios');
	}
}
