Exame época normal 2008/2009

EXERCICIO 2
b) Colocaria na classe Biblioteca!

//Para um dado Livro com titulo e autor:
public String verifica(String titulo, String autor){
	//percorre lista de livros (autor + titulo)
	for(i=0;i<ListaLivros.size();i++){
		if(ListaLivros.get(i).get_titulo().equals(titulo))&&(ListaLivros.get(i).get_autor().equals(autor)){
			//Se encontrou livro com (autor + titulo) verifica se esta emprestado:
			if(ListaLivros.get(i).get_Emprestado()==false){
				return "Livro encontrado e disponível";
				}
			else{
				//devolve string com nome do leitor detentor do livro e ainda a data até à qual o livro está ocupado:
				return "Livro encontrado mas emprestado ao leitor "+Emprestado_a_quem(ListaLivros.get(i).get_n_registo())+"até ao dia "+Ate_que_dia(ListaLivros.get(i).get_n_registo()).toString();
				}
			}
		else{
			//Se não encontrou um livro com (autor+livro):
			return "Livro não encontrado";
		}
	}
}
//Para um dado registo de um livro percorre lista de empréstimos :
public String Emprestado_a_quem(int n_registo){
	for(j=0;j<ListaEmprestimos.size();j++){
		//se encontra o registo :
		if(ListaEmprestimos.get(j).get_num_registo()==num_registo){
			//percorre lista de leitores a procura de n_leitor:
			for(k=0; k<ListaLeitores.size();k++){
				if(ListaLeitores.get(k).get_n_leitor()==ListaEmprestimos.get(j).get_num_leitor()){
					//para fazer o get do nome do leitor:
					return get_nome();
				}
			}
		}
	}
}
//Para um dado refisto de um livro percorre lista de livros:
public Date Ate_que_Dia(n_registo){
	for(i=0; i<ListaLivros.size(); i++){
		if(ListaLivros.get(i).get_n_registo()==n_registo){
			//Se registo existe em livros procura-o em emprestimos: 
			for(j=0; j<ListaEmprestimos.size(); j++){
				if( ListaEmprestimos.get(j).get_num_registo() == ListaLivros.get(i).get_num_registo()){
					// se são iguais vai verificar se o leitor é aluno :
					for (k=0; k<ListaLeitores.size(); k++){
						if(ListaLeitores.get(k) instanceof Aluno){
							//Para um leitor determina o limite de entrega isto é:data de emprestimo para a soma da data com o tempomax:
							return ListaEmprestimos.get(j).get_dataEmprestimo().SomaData(ListaLeitores.get(k ).get_tempomax());

EXERCICIO 3

a) COLOCARIA NA CLASSE BIBLIOTECA!!!

