import java.util.ArrayList;
//classe que trabalha com os ArraysList

public class Contactos {

	ArrayList <Contacto> contactosArray;
	
	Contactos(){
		contactosArray = new ArrayList<Contacto>();
	}
	
	public Contacto adicionaContacto(Contacto e){
		contactosArray.add(e);
		return e;
	}
	
	public Contacto eliminaContacto(String nome){
		for (int i=0; i<contactosArray.size(); i++){
			if(contactosArray.get(i).nome==nome){
				return contactosArray.remove(i);
			}
		}
		return null;
	}
}