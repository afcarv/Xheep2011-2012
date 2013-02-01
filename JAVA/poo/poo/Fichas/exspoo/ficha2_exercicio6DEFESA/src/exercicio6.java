
public class exercicio6 {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		// TODO Auto-generated method stub
		
		int limite=50, n;
		
		System.out.print("introduza o numero de ordenadas que vai usar: ");
		n=User.readInt();
		
		float array [] = new float [n]; //array de floats 
		
		for (int i=0; i<array.length; i++){//vai gerir valores aleatorios e meter num array
			array[i] = (int)(Math.random()*limite);//a funçao random cria valores aleatorios de 0 a 1 multiplicamos por limite para ser de 0 a limite
			}
		
		for (int j=0; j<n-1; j++){ //n-1 porque a ultima posiçao nao vai ser feita dessa maneira mas sim do que vem asguir
			array[j] = ((array[j]+array[j+1])/2);//tou a meter no array a media da coordenada com a sguinte
		}
			
		array[array.length-1]=((array[array.length-1]+array[0])/2);//para a ultima coordenada é preciso somá-la com a primeira senão iriamos obter uma recta horizontal com o valor da ultima coordenada

		for (int r=0; r<n; r++){
			System.out.print(array[r] + "  ");
			}
		
		String deseja;
		
		System.out.print("\nDeseja fazer nova iteraçao?(sim/nao): ");
		deseja = User.readString();// OU SIM OU NAO
		
		deseja = deseja.toLowerCase ();
		
		if (deseja.equals("sim")==true){
			itera(array, n);//se disser sim vai fazer nova iteraçao
		}
		else{
			for (int r=0; r<n; r++){
				System.out.print(array[r] + "  "); //se disser nao vai apresentar o array
		}
	}
}
		
	static void itera(float array[], int n){ //é a funçao que itera 
		
		
		for (int j=0; j<n-1; j++){
			array[j] = ((array[j]+array[j+1])/2);
		}
		
		array[array.length-1]=((array[array.length-1]+array[0])/2);//a ultima coordenada é calculada desta forma (ultima mais a primeira a dividr por 2)
			
		for (int r=0; r<n; r++){
			System.out.print(array[r] + "  ");
		}
		
		String deseja;
		System.out.print("\ndeseja alisar(iterar) de novo?(sim/nao): ");
		deseja = User.readString();//mesma merda aqui....porque a outra funçao chama esta por meio de *itera*
		
		deseja = deseja.toLowerCase ();
		
		if (deseja.equals("sim")==true){
			itera(array, n);
		}
		
		else{
			for (int l=0; l<n; l++){
				System.out.print("\n"+array[l] + "  ");
			}
		}
	}
}