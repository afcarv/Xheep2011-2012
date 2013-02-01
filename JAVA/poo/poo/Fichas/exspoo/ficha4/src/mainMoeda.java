
public class mainMoeda {

	public static void main(String[] args) {
		
		moeda m = new moeda(User.readString(), User.readDouble());
		
		String para=""; //para o que quer converter?
		
		while(!(para=User.readString()).contentEquals("end")) //se o user escerever end acaba
			System.out.println(m.converteTo(para).toString());
	}
	class moeda{
	
		String tipos = {"euro", "dollar", "yene", "chf" };
	
		double exchangeRate[][] = {{ 1, 2, 3, 4}, {1.0/2.0, 1, 2, 3}, {1.0/2.0, 1.0/2.0, 1, 2}, {1.0/2.0, 1.0/2.0, 1.0/2.0, 1}};
		
		double quantidade = 0;
		String tipo = "euro";
		
		moeda(String tipo, double g){
			this.tipo; this.quantidade=g;}
		moeda converte(String tipo){
			quantidade=quantidade*exchangeRate[indexOf(this.tipo)][indexOf(tipo)];
			this.tipo = tipoCorrecto(tipo);//tenho definir uma funçao tipo correcto para ver se dava
			return this;
		}
	}
}

int indexOf(String tipo){
	for(int i=0; i<tipos.length(); i++)
		if (tipos[i].equalsIgualCase(tipo))
			return i;
	return indexOf(this.tipo);
}
}