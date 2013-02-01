Exame época normal 2008/2009

ATENÇAO!---> só tenho de chamar a função Emprestado_a_quem() sem . porque é uma funçao qu esta  aser chamada na mesma classe.
ATENÇAO!---> .equals() para strings e == para o resto!


EXERCICIO 2

	Date data_hoje = new Date();
	data_hoje = data_hoje.getDataHoje();
	
b) Colocaria na classe Biblioteca!

public String verifica(String titulo, String autor){
	for(i=0;i<ListaLivros.size();i++){
		if(ListaLivros.get(i).get_titulo().equals(titulo))&&(ListaLivros.get(i).get_autor().equals(autor)){
			if(ListaLivros.get(i).get_Emprestado()==false){
				return "Livro encontrado e disponível";
				}
			else{
				return "Livro encontrado mas emprestado ao leitor "+Emprestado_a_quem(ListaLivros.get(i).get_n_registo())+"até ao dia "+Ate_que_dia(ListaLivros.get(i).get_n_registo()).toString();
				}
			}
		else{
			return "Livro não encontrado";
		}
	}
}

public String Emprestado_a_quem(int n_registo){
	for(j=0;j<ListaEmprestimos.size();j++){
		if(ListaEmprestimos.get(j).get_num_registo()==n_registo){
			for(k=0; k<ListaLeitores.size();k++){
				if(ListaLeitores.get(k).get_n_leitor()==ListaEmprestimos.get(j).get_num_leitor()){
					return ListaLeitores.get(k).get_nome();
				}
			}
		}
	}
}

public Date Ate_que_Dia(n_registo){
	for(i=0; i<ListaLivros.size(); i++){
		if(ListaLivros.get(i).get_n_registo()==n_registo){
			for(j=0; j<ListaEmprestimos.size(); j++){
				if( ListaEmprestimos.get(j).get_num_registo() == ListaLivros.get(i).get_n_registo()){
					for (k=0; k<ListaLeitores.size(); k++){
						//if(ListaLeitores.get(k) instanceOf Aluno){****nao é necessario uma vez que HA POLIMORFISMO!
							return ListaEmprestimos.get(j).get_dataEmprestimo().SomaData(ListaLeitores.get(k).get_tempomax());
						//else if(ListaLeitores.get(k) instanceOf Aluno){****sendo assim isto nao vai ser necessario!
							return ListaEmprestimos.get(j).get_dataEmprestimo().SomaData(ListaLeitores.get(k).get_tempomax());
						}
						}
					}
				}
			}
		}
	}
}

EXERCICIO 3

a) COLOCARIA NA CLASSE BIBLIOTECA!!!

public void WriteToFile(){
	try{
		File f = new File("Atrasados.txt");
		FileWriter fs = new FileWriter(f);
		PrintWriter ps = new PrintWriter(fs);
		String Atrasados = " ";
	
		for(i=0; i<ListaLivros.size(); i++){
			for(j=0; j<ListaEmprestimos.size(); j++){
				if(ListaLivros.get(i).get_n_registo() == ListaEmprestimos.get(j).get_num_registo()){
					for (k=0; k<ListaLeitores(); k++){
						if  (get_DataHoje().diferencaData(ListaEmprestimos.get(j).get_dataEmprestimo()) > ListaLeitores.get(k).get_tempomax()){
							Atrasados += "Livro: "+ListaLivros.get(i).get_titulo() + ListaLeitores.get(k).toString();
							
Usando polimorfismo...fica:
//na classe Aluno fica:
public String toString(){
	return super.toString() + "nº de aluno: "+n_aluno;
	e ainda..
public int get_tempomax(){
	return 3;
	
//na classe Docente fica:
public String toString(){
	return super.toString() + "categoria: "+categoria;
	e ainda..
public int get_tempomax(){
	return 10;

ou...
						//if (ListaLeitores.get(k) instanceof Aluno){
							if  (get_DataHoje().diferencaData(ListaEmprestimos.get(j).get_dataEmprestimo()) > ListaLeitores.get(k).get_tempomax()){
								Atrasados += ListaLeitores.get(k).get_nome() + ListaLeitores.get(k).get_n_aluno()+ " " + ListaLeitores(k).get_nome() + " "+ Num_Dias_Atraso_Devolucao(ListaLivros.get(i).get_n_registo());
							else if (ListaLeitores.get(k) instanceof Aluno){
								if (get_DataHoje().diferencaData(ListaEmprestimos.get(j).get_dataEmprestimo()) > ListaLeitores.get(k).get_tempomax()){
									Atrasados += ListaLeitores.get(k).get_categoria()+ " " + ListaLeitores(k).get_nome() + " "+ Num_Dias_Atraso_Devolucao(ListaLivros.get(i).get_n_registo());
								}
							}
							}
						}
					}
					ps.println(Atrasados);
					}
				}
			}
		
		ps.close();
		}
		catch (IOException e){
			System.out.println("Ocorreu uma excepção "+e+" ao criar o FileWriter fs");
			}
}
public int Num_Dias_Atraso_Devolucao(n_registo){
	for(i=0; i<ListaLivros.size(); i++){
		for(j=0; j<ListaEmrestimos.size(); j++){
			if(ListaLivros.get(i).get_n_registo() == ListaEmprestimos.get(j).get_num_registo()){
				for (k=0; k<ListaLeitores.size(); k++){
					return get_DataHoje().diferencaData(ListaLeitores.get(k).get_tempomax());
					
					//
					if (ListaLeitores.get(k) instanceof Aluno){
						return get_DataHoje().diferencaData(ListaLeitores.get(k).get_tempomax());
					else if(ListaLeitores.get(k) instanceof Docente){
						return get_DataHoje().diferencaData(ListaLeitores.get(k).get_tempomax());
					}
					}
				}
			}
		}
	}
}