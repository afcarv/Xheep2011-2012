import java.util.ArrayList;

public abstract class Leitor {
	
	protected String nome;
	protected String morada;
	protected int idade;
	protected double telefone;
	//protected ArrayList<Requisicao> requisicoes;
	
	public Leitor(String nome, String morada, int idade, double telefone/*, ArrayList<Requisicao> requisicoes*/ ){
		this.nome=nome;
		this.morada=morada;
		this.idade=idade;
		this.telefone=telefone;
		//requisicoes = new ArrayList<Requisicao>();
	}
	
	/*public void addRequisicao(Requisicao j){
		requisicoes.add(j);
	}*/
	
	public abstract boolean passouPrazo(int hoje, int data);
	
	
}