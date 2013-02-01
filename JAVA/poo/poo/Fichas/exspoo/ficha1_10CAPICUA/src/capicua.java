
public class capicua {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		// TODO Auto-generated method stub
		
		
		int i=0;
		int numero,numero_aux;
		System.out.println("introduza a: ");
		numero=User.readInt();
		numero_aux=numero;
		while (numero_aux>0){   // ves o tamanho do numero pa criar o array á medida
			numero_aux=numero_aux/10;
			i++;
		}
		if (i<=1){  // se o numero for menor qe 9 é uma capicua, pk tem 1 digito
			System.out.println("o numero e' uma capicua");
		}
		else{
			if(inverter(numero,i)==0){
				System.out.println("o numero e' uma capicua");
			}
			else {
				System.out.println("o numero nao e' uma capicua");
			}
		}
		
		

	}
	
	static int inverter(int numero,int i){
		
		
		int invertido[]= new int[i];
		int normal[]= new int[i];
		int aux=0,resto,a=0;
		
		
		
		
		while (numero>0){            // preenche o array invertido
			resto=numero%10;
			invertido[aux]=resto;
			numero=numero/10;
			aux++;
		}
		
		
		
		
		
		while (aux>0){            // preenches o array normal
			
			aux--;
			normal[a]=invertido[aux];
			a++;
			
			
		}
		
		
		
		while (a>0){
			a--;
			if (invertido[a]!=normal[a]){
				return 1;
			}
			else{
				
				continue; //volta ao inicio do ciclo
			}
			
		}
		return 0;
		
	}
}