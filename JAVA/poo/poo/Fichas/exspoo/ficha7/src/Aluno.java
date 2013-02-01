import java.util.ArrayList;

public class Aluno extends Leitor{


	protected String tipo;
	protected int max_livros;
	protected int max_dias;
	
	public Aluno(String nome, String morada, int idade, double telefone/*, ArrayList<Requisicao> requisicoes*/){
		super(nome,morada,idade,telefone/*,requisicoes*/);
		this.tipo = "aluno";
		max_livros = 3;
		this.max_dias = 8;
	}
	
	public boolean passouPrazo(int hoje, int data){
		return hoje-data>3?true:false;
	}
	
	public int get_maxlivros_al(){
		return max_livros;
	}
	public int get_maxdias_al(){
		return max_dias;
	}
}