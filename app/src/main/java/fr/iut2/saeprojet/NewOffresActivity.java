package fr.iut2.saeprojet;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ScrollView;
import android.widget.TextView;

import java.lang.reflect.Array;
import java.util.ArrayList;

import fr.iut2.saeprojet.api.APIClient;
import fr.iut2.saeprojet.api.ResultatAppel;
import fr.iut2.saeprojet.entity.Offre;
import fr.iut2.saeprojet.entity.OffresResponse;

public class NewOffresActivity extends StageAppActivity {

    private LinearLayout newOffres, newOffresList;
    private ScrollView newOffresScroll;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_new_offres);

        newOffres = findViewById(R.id.new_offres);
        newOffresList = findViewById(R.id.new_offres_list);
        newOffresScroll = findViewById(R.id.new_offres_scroll);

        APIClient.getOffres(this, new ResultatAppel<OffresResponse>() {
            @Override
            public void traiterResultat(OffresResponse response) {

                ArrayList<Offre> newOffres = new ArrayList<Offre>(response.offres);

                for (Offre offre : response.offres) {
                    for (String offresConsultee : getEtudiant().offreConsultees) {
                        if (offre.offreConsultees.contains(offresConsultee)) {
                            newOffres.remove(offre);
                            break;
                        }
                    }
                }

                for (Offre offre : newOffres) {
                    LinearLayout newOffreView = new LinearLayout(getApplicationContext());
                    newOffreView.setOrientation(LinearLayout.HORIZONTAL);
                    newOffreView.setBackground(getResources().getDrawable(R.drawable.border));

                    TextView newOffreViewTitle = new TextView(getApplicationContext());
                    newOffreViewTitle.setText(offre.intitule);
                    newOffreViewTitle.setLayoutParams(new LinearLayout.LayoutParams(0, LinearLayout.LayoutParams.WRAP_CONTENT, 1));
                    newOffreViewTitle.setLines(2);

                    newOffreView.addView(newOffreViewTitle);

                    newOffreView.setOnClickListener(new View.OnClickListener() {
                        @Override
                        public void onClick(View v) {
                            Intent intent = new Intent(NewOffresActivity.this, OffreActivity.class);
                            intent.putExtra(OffreActivity.OFFRE_KEY, offre);
                            intent.putExtra(OffreActivity.ETUDIANT_KEY, getEtudiant());
                            startActivity(intent);
                        }
                    });

                    newOffresList.addView(newOffreView);
                }

                TextView newOffreViewTitle = new TextView(getApplicationContext());
                newOffreViewTitle.setText("Fin des offres");
                newOffreViewTitle.setBackground(getResources().getDrawable(R.drawable.border));
                newOffreViewTitle.setLayoutParams(new LinearLayout.LayoutParams(0, LinearLayout.LayoutParams.WRAP_CONTENT, 1));
                newOffresList.addView(newOffreViewTitle);
            }

            @Override
            public void traiterErreur() {}
        });
    }
}