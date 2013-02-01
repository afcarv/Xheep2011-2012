package Ficha4Ex4;


import common.User;


public class Ficha4Ex4 {

	public static void main(String[] args) {
		System.out.println("\n Insira o numero de lados do Poligono: ");
		Poligono quadrado=new Poligono(User.readInt());
		/*DecimalFormat decFor=new DecimalFormat("0.0");
		for(int i=0;i<(quadrado.lados.length);i++){
			System.out.println("Angulo "+i+" : "+decFor.format(quadrado.angulos[i].graus)+"º");
			System.out.format("Lado %d : %.2f%n",i,quadrado.lados[i]);}
		*/
		if(quadrado.VerificaLados() && quadrado.VerificaAngulos())
			System.out.println("\n O Poligono é regular !");
		else
			System.out.println("\n O Poligono nao é regular !");
	}

}
