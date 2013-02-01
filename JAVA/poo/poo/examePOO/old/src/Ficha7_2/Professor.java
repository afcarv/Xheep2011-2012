package Ficha7_2;

import java.util.ArrayList;

public class Professor extends Leitor {

	protected String tipo;
	protected int max_livros;
	protected int max_dias;
	
	public Professor(String nome, String morada, int idade, double telefone/*, ArrayList<Requisicao> requisicoes*/){
		//herda atributos gerais de um leitor:
		super(nome,morada,idade,telefone/*,requisicoes*/);
		this.tipo = "professor";
		max_livros = 10;
		this.max_dias = 60;
	}
	
	public boolean passouPrazo(int hoje, int data){
		return hoje-data>60?true:false;
	}
	public int get_max_livros_prof(){
		return max_livros;
	}
	public int get_maxdias_prof(){
		return max_dias;
	}
}
