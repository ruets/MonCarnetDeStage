package fr.iut2.saeprojet.ui.candidatures;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;

import java.util.ArrayList;

import fr.iut2.saeprojet.MainActivity;
import fr.iut2.saeprojet.R;
import fr.iut2.saeprojet.api.APIClient;
import fr.iut2.saeprojet.api.ResultatAppel;
import fr.iut2.saeprojet.databinding.FragmentCandidaturesBinding;
import fr.iut2.saeprojet.entity.Candidature;
import fr.iut2.saeprojet.entity.CandidaturesResponse;
import fr.iut2.saeprojet.entity.Entreprise;
import fr.iut2.saeprojet.entity.EntreprisesResponse;
import fr.iut2.saeprojet.entity.Offre;
import fr.iut2.saeprojet.entity.OffresResponse;

public class CandidaturesFragment extends Fragment {

    private FragmentCandidaturesBinding binding;
    private LinearLayout candidaturesList;

    public View onCreateView(@NonNull LayoutInflater inflater,
                             ViewGroup container, Bundle savedInstanceState) {

        binding = FragmentCandidaturesBinding.inflate(inflater, container, false);
        View root = binding.getRoot();

        init();

        return root;
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;
    }

    private void init() {
        candidaturesList = binding.candidaturesList;

        MainActivity mainActivity = (MainActivity) getActivity();

        APIClient.getCandidatures(mainActivity, new ResultatAppel<CandidaturesResponse>() {
            @Override
            public void traiterResultat(CandidaturesResponse candidatures) {
                ArrayList<LinearLayout> candidaturesViewsAccepted = new ArrayList<>();
                ArrayList<LinearLayout> candidaturesViewsPending = new ArrayList<>();
                ArrayList<LinearLayout> candidaturesViewsRefused = new ArrayList<>();
                ArrayList<Candidature> othersCandidatures = new ArrayList<>();

                for (Candidature candidature : candidatures.candidatures) {
                    if (candidature.compteEtudiant.equals(mainActivity.getCompte_Id())) {
                        String[] offreId = candidature.offre.split("/");
                        String offreIdString = offreId[offreId.length - 1];

                        APIClient.getOffre(mainActivity, Long.parseLong(offreIdString), new ResultatAppel<Offre>() {
                            @Override
                            public void traiterResultat(Offre offre) {
                                LinearLayout candidatureView = new LinearLayout(mainActivity);
                                candidatureView.setOrientation(LinearLayout.HORIZONTAL);
                                candidatureView.setBackground(getResources().getDrawable(R.drawable.border));

                                TextView candidatureViewTitle = new TextView(mainActivity);
                                candidatureViewTitle.setText(offre.intitule);
                                candidatureViewTitle.setLayoutParams(new LinearLayout.LayoutParams(0, LinearLayout.LayoutParams.WRAP_CONTENT, 1));
                                candidatureViewTitle.setLines(2);

                                ImageView candidatureViewIcon = new ImageView(mainActivity);
                                switch (candidature.etatCandidature) {
                                    case "/api/etat_candidatures/1":
                                    case "/api/etat_candidatures/2":
                                    case "/api/etat_candidatures/4":
                                    case "/api/etat_candidatures/5":
                                        candidatureViewIcon.setImageDrawable(getResources().getDrawable(R.drawable.pending_icon));
                                        candidatureView.addView(candidatureViewTitle);
                                        candidatureView.addView(candidatureViewIcon);

                                        candidaturesViewsPending.add(candidatureView);
                                        break;
                                    case "/api/etat_candidatures/3":
                                        candidatureViewIcon.setImageDrawable(getResources().getDrawable(R.drawable.refused_icon));
                                        candidatureView.addView(candidatureViewTitle);
                                        candidatureView.addView(candidatureViewIcon);

                                        candidaturesViewsRefused.add(candidatureView);
                                        break;
                                    case "/api/etat_candidatures/6":
                                        candidatureViewIcon.setImageDrawable(getResources().getDrawable(R.drawable.check_icon));
                                        candidatureView.addView(candidatureViewTitle);
                                        candidatureView.addView(candidatureViewIcon);

                                        candidaturesViewsAccepted.add(candidatureView);
                                        break;
                                }

                                // Si toutes les candidatures ont été traitées, on les affiche
                                if (candidaturesViewsAccepted.size() + candidaturesViewsPending.size() + candidaturesViewsRefused.size() + othersCandidatures.size() == candidatures.candidatures.size()) {
                                    for (LinearLayout candidatureViewAccepted : candidaturesViewsAccepted) {
                                        candidaturesList.addView(candidatureViewAccepted);
                                    }

                                    for (LinearLayout candidatureViewPending : candidaturesViewsPending) {
                                        candidaturesList.addView(candidatureViewPending);
                                    }

                                    for (LinearLayout candidatureViewRefused : candidaturesViewsRefused) {
                                        candidaturesList.addView(candidatureViewRefused);
                                    }
                                }
                            }

                            @Override
                            public void traiterErreur() {
                                TextView candidature = new TextView(mainActivity);
                                candidature.setText("Erreur");

                                candidaturesList.addView(candidature);
                            }
                        });
                    } else {
                        othersCandidatures.add(candidature);
                    }
                }
            }

            @Override
            public void traiterErreur() {
                TextView candidature = new TextView(mainActivity);
                candidature.setText("Erreur");

                candidaturesList.addView(candidature);
            }
        });
    }
}