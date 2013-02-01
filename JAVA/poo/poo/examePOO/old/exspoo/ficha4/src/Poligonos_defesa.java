
public class Poligonos_defesa {//main
	
	
	public static void main(String[] args) {
		System.out.println("introduza o numero de lados do poligono(max 10): ");
		int n=User.readInt();
		
		double array[][] = new double[n][2];//inicializa o array a zero
		Poligono obj;
		
		for (int i=0; i<n; i++){
			if(n<=10){
				System.out.println("introduza coordenada x: ");
				int x=User.readInt();
				System.out.println("introduza coordenada y: ");
				int y=User.readInt();
				array[i][0] = x;
				array[i][1] = y;
			}
		}
		if (n>10){
			System.out.println("O Poligono não pode ter mais do que 10 lados!");
		}
		
		
		obj = new Poligono(array);
		
		obj.regular();
	}
}