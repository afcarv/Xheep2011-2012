import java.util.ArrayList;

//faz a gestao de contactos na medida em que nao tem metodos associados ao arraylist mas sim ao contacto em si

public class GestaoContactos {
//sao ArraysList
	Contactos Familia;
	Contactos Amigos;
	Contactos Profissionais;

	/*private ArrayList<Contactos> db;
	
	public GestaoContactos(){
		db = new ArrayList<Contactos>();
	}*/
	
	public Contacto adicionaContacto(Contacto e){
		return Familia.adicionaContacto(e);
	}
	public Contacto adicionaContactoAmigos(Contacto e){
		return Amigos.adicionaContacto(e);
	}
	public Contacto adicionaContactoProfissionais(Contacto e){
		return Profissionais.adicionaContacto(e);
	}
	

}
