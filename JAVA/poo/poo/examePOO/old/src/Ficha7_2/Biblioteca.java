package Ficha7_2;

import java.util.ArrayList;

public class Biblioteca {

	//guarda os leitores e os livros em biblioteca(lógico)
	private ArrayList<Leitor> db;
	private ArrayList<Livro> db2;
	private Requisicao req;
	//constructor da biblioteca com tudo instanciado:
	public Biblioteca(){
		db = new ArrayList<Leitor>();
		db2 = new ArrayList<Livro>();
		req = new Requisicao();
		}
	
	public Biblioteca(ArrayList<Leitor> db, ArrayList<Livro> db2){
		this.db = db;
		this.db2 = db2;
		req = new Requisicao();
	}
	
	public void add(Leitor e){
		db.add(e);
	}
	public void add(Livro e){
		db2.add(e);
	}
	public void addReq(Livro e){
		req.addLivro(e);
	}
	
	public void get_livros_por_area(String area){
		for(Livro e:db2){
			if(e.get_categoria().equals(area)){
				System.out.println(e.get_titulo());
			}
		}
	}
	public void get_livros_por_autor(String autor){
		for (Livro e:db2){
			if(e.get_autor().equals(autor)){
				System.out.println(e.get_titulo());
			}
		}
	}
	//metodo que verifica se uma cota ja existe em requisiçao
	public void checkReq(double cota){
		if (req.req_verify(cota)){
			System.out.println("O livro que escolheu ja foi requisitado!");
		}
		else{
			System.out.println("O livro foi requisitado com sucesso!");
		}
		//se requisitar um livro deve adicioná-lo a requisiçoes
	}
	
}