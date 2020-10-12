class Filter {
  constructor() {
    this.copyRightLink = jQuery(".copyright-link");
    this.culturalHeritageLink = jQuery(".cultural-heritage-link");
    this.resultsCards = jQuery(".cards_wrap");
    this.cardItem = jQuery(".card_inner");
    this.currentlyDisplayed = "all";
    this.closestReadMore = {};
    this.events();
  }

  events() {
    this.copyRightLink.on("click", this.removeCulturalHeritage.bind(this));
    this.culturalHeritageLink.on("click", this.removeCopyright.bind(this));
    this.cardItem.hover(
      this.showReadMore.bind(this),
      this.hideReadMore.bind(this)
    );
  }

  showReadMore(e) {
    this.closestReadMore = jQuery(e.target)
      .closest(".card_inner")
      .find(".card_read-more");
    this.closestReadMore.removeClass("hide");
  }

  hideReadMore() {
    this.closestReadMore.addClass("hide");
  }

  removeCulturalHeritage() {
    if (this.currentlyDisplayed == "all") {
      this.resultsCards.find(".cultural-heritage").addClass('hide');
      this.currentlyDisplayed = "copyright";
    } else if (this.currentlyDisplayed == "copyright") {
      return;
    } else if (this.currentlyDisplayed == "culture") {
      this.resultsCards.find(".cultural-heritage").addClass('hide');
      this.resultsCards.find(".copyright").removeClass('hide');
      this.currentlyDisplayed = "copyright";
    }
  }

  removeCopyright() {
    if (this.currentlyDisplayed == "all") {
      this.resultsCards.find(".copyright").addClass('hide');
      this.currentlyDisplayed = "culture";
    } else if (this.currentlyDisplayed == "culture") {
      return;
    } else if (this.currentlyDisplayed == "copyright") {
      this.resultsCards.find(".copyright").addClass('hide');
      this.resultsCards.find(".cultural-heritage").removeClass('hide');
      this.currentlyDisplayed = "culture";
    }
  }
}

var filter = new Filter();
