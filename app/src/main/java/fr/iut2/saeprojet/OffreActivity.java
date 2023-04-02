package fr.iut2.saeprojet;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.text.Html;
import android.text.method.LinkMovementMethod;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

import fr.iut2.saeprojet.api.APIClient;
import fr.iut2.saeprojet.api.ResultatAppel;
import fr.iut2.saeprojet.entity.Candidature;
import fr.iut2.saeprojet.entity.CandidaturesResponse;
import fr.iut2.saeprojet.entity.Entreprise;
import fr.iut2.saeprojet.entity.EntreprisesResponse;
import fr.iut2.saeprojet.entity.EtatOffre;
import fr.iut2.saeprojet.entity.EtatOffresResponse;
import fr.iut2.saeprojet.entity.Offre;
import fr.iut2.saeprojet.entity.OffreConsultee;
import fr.iut2.saeprojet.entity.OffreConsulteeRequest;
import fr.iut2.saeprojet.entity.OffreRetenue;
import fr.iut2.saeprojet.entity.OffreRetenueRequest;

public class OffreActivity extends StageAppActivity {

    public static final String OFFRE_KEY = "offre_key";
    private Offre offre;

    private TextView offreTitle, offreStatus, offreEntreprise, offreAddress, offreDetails;
    private ImageView iconFavorite;
    private Button offreCandidate;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_offre);

        offre = getIntent().getParcelableExtra(OFFRE_KEY);

        offreTitle = findViewById(R.id.offre_title);
        offreStatus = findViewById(R.id.offre_status);
        offreEntreprise = findViewById(R.id.offre_entreprise);
        offreAddress = findViewById(R.id.offre_address);
        offreDetails = findViewById(R.id.offre_details);
        iconFavorite = findViewById(R.id.icon_favorite);
        offreCandidate = findViewById(R.id.offre_candidate);

        offreTitle.setText(offre.intitule);

        // TODO: Revoir les conditions
        if (getEtudiant().offreConsultees.isEmpty() || offre.offreConsultees.isEmpty()) {
            OffreConsulteeRequest request = new OffreConsulteeRequest();
            request.offre = offre._id;
            request.compteEtudiant = getEtudiant()._id;

            APIClient.createOffreConsultee(this, request, new ResultatAppel<OffreConsultee>() {
                @Override
                public void traiterResultat(OffreConsultee response) {}

                @Override
                public void traiterErreur() {}
            });
        } else {
            for (String offreConsultee : getEtudiant().offreConsultees) {
                if (offre.offreConsultees.contains(offreConsultee)) {
                } else {
                    OffreConsulteeRequest request = new OffreConsulteeRequest();
                    request.offre = offre._id;
                    request.compteEtudiant = getEtudiant()._id;

                    APIClient.createOffreConsultee(this, request, new ResultatAppel<OffreConsultee>() {
                        @Override
                        public void traiterResultat(OffreConsultee response) {}

                        @Override
                        public void traiterErreur() {}
                    });

                    break;
                }
            }
        }

        /*OffreConsulteeRequest request = new OffreConsulteeRequest();
        request.offre = offre._id;
        request.compteEtudiant = getEtudiant()._id;
        APIClient.createOffreConsultee(this, request, new ResultatAppel<OffreConsultee>() {
            @Override
            public void traiterResultat(OffreConsultee response) {}

            @Override
            public void traiterErreur() {}
        });
*/
        APIClient.getEtatOffres(this, new ResultatAppel<EtatOffresResponse>() {
            @Override
            public void traiterResultat(EtatOffresResponse response) {
                for (EtatOffre etatOffre : response.etatOffres) {
                    if (etatOffre._id.equals(offre.etatOffre)) {
                        offreStatus.setText(offreStatus.getText() + " " + etatOffre.etat);
                    }
                }
            }

            @Override
            public void traiterErreur() {

            }
        });

        APIClient.getEntreprises(this, new ResultatAppel<EntreprisesResponse>() {
            @Override
            public void traiterResultat(EntreprisesResponse response) {
                for (Entreprise entreprise : response.entreprises) {
                    if (entreprise._id.equals(offre.entreprise)) {
                        offreEntreprise.setText(offreEntreprise.getText() + " " + entreprise.raisonSociale);
                        offreAddress.setText(offreAddress.getText() + " " + entreprise.ville);
                    }
                }
            }

            @Override
            public void traiterErreur() {

            }
        });

        String linkText = "ici";
        String link = offre.urlPieceJointe;
        offreDetails.setText(Html.fromHtml(offreDetails.getText() + " <a href=\"" + link + "\">" + linkText + "</a>"));
        offreDetails.setMovementMethod(LinkMovementMethod.getInstance());

        for (String favoris : offre.offreRetenues) {
            if (getEtudiant().offreRetenues.contains(favoris)) {
                iconFavorite.setImageResource(R.drawable.star_filled);
            }
        }

        setOnClickFavorites();

    }

    private void setOnClickFavorites() {
        iconFavorite.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                // TODO: a réviser
                if (iconFavorite.getDrawable().equals(getResources().getDrawable(R.drawable.star_filled))) {
                    APIClient.removeOffreRetenue(OffreActivity.this, offre.id, new ResultatAppel<OffreRetenue>() {
                        @Override
                        public void traiterResultat(OffreRetenue response) {
                            iconFavorite.setImageResource(R.drawable.star_empty);
                            setOnClickFavorites();
                        }

                        @Override
                        public void traiterErreur() {

                        }
                    });
                } else {
                    OffreRetenueRequest request = new OffreRetenueRequest();
                    request.offre = offre._id;
                    request.compteEtudiant = getEtudiant()._id;
                    APIClient.createOffreRetenue(OffreActivity.this, request, new ResultatAppel<OffreRetenue>() {
                        @Override
                        public void traiterResultat(OffreRetenue response) {
                            iconFavorite.setImageResource(R.drawable.star_filled);
                            setOnClickFavorites();
                        }

                        @Override
                        public void traiterErreur() {

                        }
                    });
                }
            }
        });

        APIClient.getCandidatures(this, new ResultatAppel<CandidaturesResponse>() {
            @Override
            public void traiterResultat(CandidaturesResponse response) {
                for (Candidature candidature : response.candidatures) {
                    if (candidature.offre.equals(offre._id)) {
                        offreCandidate.setText("Modifier ma candidature");

                        offreCandidate.setOnClickListener(new View.OnClickListener() {
                            @Override
                            public void onClick(View view) {
                                Intent intent = new Intent(OffreActivity.this, CandidatureModifyActivity.class);
                                intent.putExtra(CandidatureModifyActivity.ACTION_KEY, "modify");
                                intent.putExtra(CandidatureModifyActivity.OFFRE_KEY, offre);
                                intent.putExtra(CandidatureModifyActivity.CANDIDATURE_KEY, candidature);
                                startActivity(intent);
                            }
                        });
                        break;
                    }
                }
            }

            @Override
            public void traiterErreur() {}
        });

        if (offreCandidate.getText().toString().equals("Modifier ma candidature")) {

        } else {
            offreCandidate.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    Intent intent = new Intent(OffreActivity.this, CandidatureModifyActivity.class);
                    intent.putExtra(CandidatureModifyActivity.ACTION_KEY, "create");
                    intent.putExtra(CandidatureModifyActivity.OFFRE_KEY, offre);
                    startActivity(intent);
                }
            });
        }
    }
}