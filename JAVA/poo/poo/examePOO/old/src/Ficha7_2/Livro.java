package Ficha7_2;

class Livro {
	
	Livro array_fdd;
	//atributos de um livro
	private String titulo;
	private String Autor;
	private double cota;
	private String categoria;
	
	//contructor
	public Livro(String title, String author, int cote, String categ){
		titulo = title;
		Autor = author;
		cota = cote;
		categoria = categ;
	}
	
	public String get_categoria(){
		return categoria;
	}
	public String get_autor(){
		return Autor;
	}
	public String get_titulo(){
		return titulo;
	}
	public double getCota(){
		return cota;
	}
}