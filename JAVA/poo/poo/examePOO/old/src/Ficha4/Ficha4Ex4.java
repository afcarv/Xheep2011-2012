package Ficha4;

public class Ficha4Ex4 {

	public static void main(String[] args) {
		System.out.println("\n Insira o numero de lados do Poligono: ");
		Poligono quadrado=new Poligono(User.readInt());

		
		if(quadrado.VerificaLados() && quadrado.VerificaAngulos())
			System.out.println("\n O Poligono é regular !");
		else
			System.out.println("\n O Poligono nao é regular !");
	}

}
