package Ficha5_1;

public class Medio extends Jogador {

	Medio(String Nome,int n_camisola){
		super(Nome, n_camisola);
	}
	//características próprias:
	int num_gmarcados = (int)(Math.random()*50);
	int num_assistencias = (int)(Math.random()*50);
}

	