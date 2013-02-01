
public class capicua {
	
	public static void inverte(int invertido){
		
		while (invertido>0){
			System.out.print(invertido%10);
			invertido=invertido/10;
		}	
}

	public static void main(String[] args){
		int numero;
		
		System.out.print("introduza o numero: ");
		numero=User.readInt();
		
		inverte(numero);
		
		if (numero==invertido){
			System.out.print("é capicua");
		}
		
	}
}