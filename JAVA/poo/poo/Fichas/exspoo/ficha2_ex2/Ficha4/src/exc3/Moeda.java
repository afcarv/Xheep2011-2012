package exc3;

import common.User;

public class Moeda {
	private String []tipos = {"euro","dólar","libra","franco suíço","yene"};
	private double []taxa = { 1, 1.3404, 0.77510, 1.5213, 135.57};
	public double quantidade;

	public Moeda (){
		quantidade = 1;
	}
	public Moeda (double q){
		quantidade = q;
	}
	
	public double converter (){
		String m_origem;
		String m_destino;
		int i_origem;
		int i_destino;
		double r=quantidade;
		
		System.out.print("Moeda origem: ");
		m_origem = User.readString();
		i_origem = verf_moeda(m_origem);
		
		System.out.println("");
		System.out.print("Moeda destino: ");
		m_destino = User.readString();
		i_destino = verf_moeda(m_destino);
		
		if (i_origem==-1 || i_destino==-1)
			return -1;
		
		if (i_origem != 0){
			r /= taxa[i_origem]; 
		}
		
		r *= taxa[i_destino];
		
		return r;
	}
	
	private int verf_moeda (String m){
		for(int i=0;i<tipos.length;i++){
			if (m.equals(tipos[i]))
				return i;
		}
		
		return -1;
	}
	
	
}
