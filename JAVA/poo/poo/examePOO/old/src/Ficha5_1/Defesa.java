package Ficha5_1;

class Defesa extends Jogador {

	Defesa(String Nome,int n_camisola){
		super(Nome, n_camisola);
	}
	//atributos específicos de um defesa:
	int num_rec = (int)(Math.random()*50);
	int num_faltas = (int)(Math.random()*50);
}
